// Логика за калкулатор на ДДВ (Северна Македонија): 18% општа, 5% и 10% повластени стапки.
// Ставките се менуваат САМО тука при законски измени.

export const VAT = {
    rates: [5, 10, 18],
    defaultRate: 18,
    updated: '11.11.2026',
}

const round2 = (x) => Math.round((x + Number.EPSILON) * 100) / 100

// 1234.5 → "1.234,50"
export function formatMoney(n) {
    const [i, d] = round2(n).toFixed(2).split('.')
    return i.replace(/\B(?=(\d{3})+(?!\d))/g, '.') + ',' + d
}

// Пресметка од кое било поле: 'net' (без ДДВ), 'vat' (износ на ДДВ) или 'gross' (со ДДВ)
export function computeVat(key, value, rate) {
    const v = Number(value) || 0
    if (!(v > 0)) return { net: 0, vat: 0, gross: 0 }
    const f = rate / 100

    if (key === 'net') {
        const net = round2(v)
        const vat = round2(v * f)
        return { net, vat, gross: round2(net + vat) }
    }
    if (key === 'gross') {
        const gross = round2(v)
        const net = round2(v / (1 + f))
        return { net, vat: round2(gross - net), gross }
    }
    // key === 'vat'
    const vat = round2(v)
    const net = round2(v / f)
    return { net, vat, gross: round2(net + vat) }
}

// Истиот износ без ДДВ при сите три ставки
export function compareRates(net) {
    return VAT.rates.map((rate) => ({ rate, ...computeVat('net', net, rate) }))
}

// Документ за pdfmake (Roboto има кирилица)
export function buildVatPdfDoc(res, rate, dateStr) {
    const mainRows = [
        ['Износ без ДДВ (нето)', '', res.net, ''],
        [`ДДВ`, `${rate}%`, res.vat, ''],
        ['Износ со ДДВ (бруто)', '', res.gross, 'net'],
    ]

    const mainBody = [[
        { text: 'Ставка', style: 'th' },
        { text: 'Стапка', style: 'th', alignment: 'right' },
        { text: 'Износ (МКД)', style: 'th', alignment: 'right' },
    ]]
    mainRows.forEach(([label, pct, value, kind]) => {
        const fill = kind === 'net' ? '#fff1e6' : null
        const bold = kind === 'net'
        const color = kind === 'net' ? '#FF6600' : '#1C1A17'
        mainBody.push([
            { text: label, bold, color, fillColor: fill, fontSize: bold ? 13 : 11 },
            { text: pct, alignment: 'right', color: '#6B6358', fillColor: fill },
            { text: formatMoney(value), alignment: 'right', bold, color, fillColor: fill, fontSize: bold ? 13 : 11 },
        ])
    })

    const cmpBody = [[
        { text: 'Стапка на ДДВ', style: 'th' },
        { text: 'ДДВ (МКД)', style: 'th', alignment: 'right' },
        { text: 'Износ со ДДВ (МКД)', style: 'th', alignment: 'right' },
    ]]
    compareRates(res.net).forEach((row) => {
        const active = row.rate === rate
        cmpBody.push([
            { text: `${row.rate}%`, bold: active, fillColor: active ? '#fff1e6' : null },
            { text: formatMoney(row.vat), alignment: 'right', bold: active, fillColor: active ? '#fff1e6' : null },
            { text: formatMoney(row.gross), alignment: 'right', bold: active, fillColor: active ? '#fff1e6' : null },
        ])
    })

    const layout = {
        hLineWidth: (i, node) => (i === 0 || i === 1 || i === node.table.body.length ? 1 : 0.5),
        hLineColor: (i) => (i === 1 ? '#1C1A17' : '#E5DDD0'),
        vLineWidth: () => 0,
        paddingTop: () => 7,
        paddingBottom: () => 7,
        paddingLeft: () => 8,
        paddingRight: () => 8,
    }

    return {
        pageSize: 'A4',
        pageMargins: [48, 48, 48, 70],
        defaultStyle: { font: 'Roboto', fontSize: 11, color: '#1C1A17' },
        content: [
            {
                columns: [
                    { text: 'FinanceBuddy.mk', fontSize: 16, bold: true, color: '#FF6600' },
                    { text: dateStr, alignment: 'right', color: '#6B6358', margin: [0, 4, 0, 0] },
                ],
            },
            { text: 'Пресметка на ДДВ', fontSize: 20, bold: true, margin: [0, 22, 0, 6] },
            {
                text: `Стапка на ДДВ: ${rate}%`,
                fontSize: 12,
                color: '#6B6358',
                margin: [0, 0, 0, 18],
            },
            { table: { headerRows: 1, widths: ['*', 60, 120], body: mainBody }, layout },
            { text: 'Истиот износ без ДДВ при сите три стапки', fontSize: 12, bold: true, margin: [0, 28, 0, 10] },
            { table: { headerRows: 1, widths: ['*', 110, 130], body: cmpBody }, layout },
        ],
        footer: () => ({
            margin: [48, 0, 48, 0],
            stack: [
                {
                    text: 'Пресметката е информативна. Применливата стапка на ДДВ за конкретна стока или услуга се определува според Законот за данокот на додадена вредност.',
                    fontSize: 8,
                    color: '#6B6358',
                },
                { text: 'financebuddy.mk', fontSize: 8, color: '#FF6600', margin: [0, 4, 0, 0] },
            ],
        }),
        styles: { th: { bold: true, fontSize: 10, color: '#6B6358' } },
    }
}
