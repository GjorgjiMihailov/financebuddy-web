// Логика за калкулатор на плата (бруто ↔ нето) — Северна Македонија, 2026.
// Параметрите се менуваат САМО тука при законски измени.

export const SALARY = {
    pio: 19.9,        // придонес за ПИО, %
    zdr: 7.5,         // здравствено осигурување, %
    nev: 0.1,         // невработеност, %
    povr: 0.5,        // повреда на работа и професионално заболување, %
    tax: 10,          // данок на личен доход, %
    personal: 10932,  // лично ослободување (месечно), МКД
    minGross: 38508,  // минимална бруто плата, МКД
    avgGross: 69141,  // просечна бруто плата, МКД
    updated: '11.11.2026',
}

const contribPct = SALARY.pio + SALARY.zdr + SALARY.nev + SALARY.povr
const kfac = 1 - contribPct / 100
const t = SALARY.tax / 100

export const CONTRIB_TOTAL_PCT = Math.round(contribPct * 100) / 100

const r = (x) => Math.round(x)

export function formatMkd(x) {
    return String(r(x)).replace(/\B(?=(\d{3})+(?!\d))/g, '.')
}

export function formatPct(x) {
    return x.toFixed(2).replace('.', ',') + '%'
}

// Бруто → сите ставки
export function calcSalary(g) {
    const pio = r((g * SALARY.pio) / 100)
    const zdr = r((g * SALARY.zdr) / 100)
    const nev = r((g * SALARY.nev) / 100)
    const pov = r((g * SALARY.povr) / 100)
    const contrib = pio + zdr + nev + pov
    const after = g - contrib
    const base = Math.max(0, after - SALARY.personal)
    const tax = r(base * t)
    return { g, pio, zdr, nev, pov, contrib, after, base, tax, net: after - tax }
}

// Приближна проценка на бруто од вредност на произволно поле
function estimate(key, v) {
    const P = SALARY.personal
    switch (key) {
        case 'g': return v
        case 'pio': return v / (SALARY.pio / 100)
        case 'zdr': return v / (SALARY.zdr / 100)
        case 'nev': return v / (SALARY.nev / 100)
        case 'pov': return v / (SALARY.povr / 100)
        case 'contrib': return v / (contribPct / 100)
        case 'after': return v / kfac
        case 'base': return (v + P) / kfac
        case 'tax': return (v / t + P) / kfac
        case 'net': return (v <= P ? v : (v - P * t) / (1 - t)) / kfac
        default: return v
    }
}

// Бруто од вредност на кое било поле (точно совпаѓање, инаку бинарно пребарување)
export function solveGross(key, v) {
    if (!(v > 0)) return 0
    if (key === 'g') return r(v)
    v = r(v)
    const e = Math.max(0, r(estimate(key, v)))
    for (let d = 0; d <= 6; d++) {
        if (e - d >= 0 && calcSalary(e - d)[key] === v) return e - d
        if (calcSalary(e + d)[key] === v) return e + d
    }
    let lo = 0
    let hi = Math.max(1000, e * 2 + 1000)
    while (lo < hi) {
        const m = Math.floor((lo + hi) / 2)
        if (calcSalary(m)[key] >= v) hi = m
        else lo = m + 1
    }
    if (lo > 0 && Math.abs(calcSalary(lo - 1)[key] - v) < Math.abs(calcSalary(lo)[key] - v)) return lo - 1
    return lo
}

// Документ за pdfmake (Roboto има кирилица)
export function buildPdfDoc(c, dateStr) {
    const rows = [
        ['Бруто плата', '', c.g, 'sum'],
        ['Придонеси за ПИО', formatPct(SALARY.pio), c.pio],
        ['Придонеси за здравствено осигурување', formatPct(SALARY.zdr), c.zdr],
        ['Придонес за невработеност', formatPct(SALARY.nev), c.nev],
        ['Придонес за повреда на работа и проф. заболување', formatPct(SALARY.povr), c.pov],
        ['Вкупно придонеси', '', c.contrib, 'sum'],
        ['Бруто плата намалена за придонеси', '', c.after],
        ['Лично ослободување', '', SALARY.personal],
        ['Даночна основа', '', c.base],
        ['Данок на личен доход', formatPct(SALARY.tax), c.tax],
        ['Нето плата', '', c.net, 'net'],
    ]

    const body = [[
        { text: 'Ставка', style: 'th' },
        { text: 'Стапка', style: 'th', alignment: 'right' },
        { text: 'Износ (МКД)', style: 'th', alignment: 'right' },
    ]]

    rows.forEach(([label, pct, value, kind]) => {
        const fill = kind === 'net' ? '#fff1e6' : null
        const bold = kind === 'sum' || kind === 'net'
        const color = kind === 'net' ? '#FF6600' : '#1C1A17'
        const fontSize = kind === 'net' ? 13 : 11
        body.push([
            { text: label, bold, color, fillColor: fill, fontSize },
            { text: pct, alignment: 'right', color: '#6B6358', fillColor: fill },
            { text: formatMkd(value), alignment: 'right', bold, color, fillColor: fill, fontSize },
        ])
    })

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
            { text: 'Пресметка на бруто и нето плата — 2026', fontSize: 20, bold: true, margin: [0, 22, 0, 6] },
            {
                text: `Бруто: ${formatMkd(c.g)} МКД   |   Нето: ${formatMkd(c.net)} МКД`,
                fontSize: 12,
                color: '#6B6358',
                margin: [0, 0, 0, 18],
            },
            {
                table: { headerRows: 1, widths: ['*', 60, 110], body },
                layout: {
                    hLineWidth: (i, node) => (i === 0 || i === 1 || i === node.table.body.length ? 1 : 0.5),
                    hLineColor: (i) => (i === 1 ? '#1C1A17' : '#E5DDD0'),
                    vLineWidth: () => 0,
                    paddingTop: () => 7,
                    paddingBottom: () => 7,
                    paddingLeft: () => 8,
                    paddingRight: () => 8,
                },
            },
        ],
        footer: () => ({
            margin: [48, 0, 48, 0],
            stack: [
                {
                    text: 'Пресметката е информативна и се однесува на редовна месечна плата. Не се применуваат минимална и максимална основица за придонеси.',
                    fontSize: 8,
                    color: '#6B6358',
                },
                { text: 'financebuddy.mk', fontSize: 8, color: '#FF6600', margin: [0, 4, 0, 0] },
            ],
        }),
        styles: { th: { bold: true, fontSize: 10, color: '#6B6358' } },
    }
}
