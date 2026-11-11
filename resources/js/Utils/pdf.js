// Заедничко вчитување на pdfmake (PDF се генерира во пребарувачот; се вчитува дури при првиот клик).
const PDF_CDN = 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.10/'

function loadScript(src) {
    return new Promise((resolve, reject) => {
        const s = document.createElement('script')
        s.src = src
        s.onload = resolve
        s.onerror = reject
        document.head.appendChild(s)
    })
}

export async function ensurePdfMake() {
    if (window.pdfMake && window.pdfMake.vfs) return window.pdfMake
    await loadScript(PDF_CDN + 'pdfmake.min.js')
    await loadScript(PDF_CDN + 'vfs_fonts.js')
    return window.pdfMake
}

export function todayString() {
    const d = new Date()
    const p = (n) => String(n).padStart(2, '0')
    return `${p(d.getDate())}.${p(d.getMonth() + 1)}.${d.getFullYear()}`
}
