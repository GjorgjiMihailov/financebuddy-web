<script setup>
import { computed, ref } from 'vue'
import { SALARY, calcSalary, solveGross, formatMkd, formatPct, buildPdfDoc } from '@/Utils/salary'

const gross = ref(0)
const activeId = ref(null)
const raw = ref('')
const pdfLoading = ref(false)
const pdfError = ref('')

const c = computed(() => calcSalary(gross.value))
const belowMin = computed(() => gross.value > 0 && gross.value < SALARY.minGross)
const minNet = calcSalary(SALARY.minGross).net
const avgNet = calcSalary(SALARY.avgGross).net

const rows = [
    { id: 'g', key: 'g', label: 'Бруто плата', kind: 'sum' },
    { id: 'pio', key: 'pio', label: 'Придонеси за ПИО', pct: SALARY.pio },
    { id: 'zdr', key: 'zdr', label: 'Придонеси за здравствено осигурување', pct: SALARY.zdr },
    { id: 'nev', key: 'nev', label: 'Придонес за невработеност', pct: SALARY.nev },
    { id: 'pov', key: 'pov', label: 'Придонес за повреда на работа и проф. заболување', pct: SALARY.povr },
    { id: 'contrib', key: 'contrib', label: 'Вкупно придонеси', kind: 'sum' },
    { id: 'after', key: 'after', label: 'Бруто плата намалена за придонеси' },
    { id: 'personal', label: 'Лично ослободување', kind: 'static' },
    { id: 'base', key: 'base', label: 'Даночна основа' },
    { id: 'tax', key: 'tax', label: 'Данок на личен доход', pct: SALARY.tax },
    { id: 'net', key: 'net', label: 'Нето плата', kind: 'net' },
]

function display(id, key) {
    if (activeId.value === id) return raw.value
    if (!gross.value) return ''
    return String(c.value[key])
}

function onInput(id, key, event) {
    activeId.value = id
    raw.value = event.target.value
    const v = Math.max(0, parseFloat(raw.value) || 0)
    gross.value = solveGross(key, v)
}

function onBlur() {
    activeId.value = null
}

function setGross(value) {
    activeId.value = null
    gross.value = value
}

const barPct = computed(() => {
    const total = c.value.g || 1
    return {
        net: (c.value.net / total) * 100,
        contrib: (c.value.contrib / total) * 100,
        tax: (c.value.tax / total) * 100,
    }
})

// PDF се генерира во пребарувачот (pdfmake се вчитува дури при првиот клик)
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

async function ensurePdfMake() {
    if (window.pdfMake && window.pdfMake.vfs) return
    await loadScript(PDF_CDN + 'pdfmake.min.js')
    await loadScript(PDF_CDN + 'vfs_fonts.js')
}

async function downloadPdf() {
    if (!gross.value || pdfLoading.value) return
    pdfError.value = ''
    pdfLoading.value = true
    const snapshot = c.value
    try {
        await ensurePdfMake()
        const d = new Date()
        const p = (n) => String(n).padStart(2, '0')
        const dateStr = `${p(d.getDate())}.${p(d.getMonth() + 1)}.${d.getFullYear()}`
        window.pdfMake.createPdf(buildPdfDoc(snapshot, dateStr)).download(`presmetka-plata-${snapshot.g}.pdf`)
    } catch {
        pdfError.value = 'PDF не може да се генерира. Проверете ја интернет врската и обидете се повторно.'
    } finally {
        pdfLoading.value = false
    }
}

const inputBase =
    'rounded-lg border border-stone/50 bg-white text-right font-semibold text-ink shadow-sm tabular-nums transition hover:border-stone focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/25 [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none'
</script>

<template>
    <div class="rounded-3xl border border-border bg-paper p-5 shadow-sm sm:p-8">
        <!-- Горни полиња: бруто / нето -->
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="calc-top-g" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-stone">Бруто плата</label>
                <div class="flex items-center gap-2">
                    <input
                        id="calc-top-g"
                        type="number"
                        inputmode="numeric"
                        min="0"
                        step="1"
                        placeholder="0"
                        :value="display('top-g', 'g')"
                        :class="[inputBase, 'w-full border-2 px-4 py-3 text-2xl']"
                        @input="onInput('top-g', 'g', $event)"
                        @blur="onBlur"
                    />
                    <span class="text-sm font-medium text-stone">МКД</span>
                </div>
            </div>
            <div>
                <label for="calc-top-net" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-stone">Нето плата</label>
                <div class="flex items-center gap-2">
                    <input
                        id="calc-top-net"
                        type="number"
                        inputmode="numeric"
                        min="0"
                        step="1"
                        placeholder="0"
                        :value="display('top-net', 'net')"
                        :class="[inputBase, 'w-full border-2 px-4 py-3 text-2xl']"
                        @input="onInput('top-net', 'net', $event)"
                        @blur="onBlur"
                    />
                    <span class="text-sm font-medium text-stone">МКД</span>
                </div>
            </div>
        </div>

        <!-- Брзи вредности -->
        <div class="mt-5 flex flex-col gap-3 text-sm text-stone">
            <div class="flex flex-wrap items-center gap-3">
                <span>Минимална плата: <strong class="text-ink">{{ formatMkd(SALARY.minGross) }}</strong> МКД бруто / <strong class="text-ink">{{ formatMkd(minNet) }}</strong> МКД нето</span>
                <button
                    type="button"
                    class="rounded-full border border-brand-orange bg-white px-4 py-1.5 text-sm font-semibold text-brand-orange transition hover:bg-brand-orange hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    @click="setGross(SALARY.minGross)"
                >
                    Прикажи минимална плата
                </button>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span>Просечна плата: <strong class="text-ink">{{ formatMkd(SALARY.avgGross) }}</strong> МКД бруто / <strong class="text-ink">{{ formatMkd(avgNet) }}</strong> МКД нето</span>
                <button
                    type="button"
                    class="rounded-full border border-brand-orange bg-white px-4 py-1.5 text-sm font-semibold text-brand-orange transition hover:bg-brand-orange hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange"
                    @click="setGross(SALARY.avgGross)"
                >
                    Прикажи просечна плата
                </button>
            </div>
        </div>

        <p v-if="belowMin" class="mt-4 rounded-xl bg-brand-orange/10 px-4 py-3 text-sm text-brand-orange-dark" role="status">
            Внесениот износ е под минималната плата ({{ formatMkd(SALARY.minGross) }} МКД бруто).
        </p>

        <p class="mt-6 text-sm text-stone">Сите бели полиња во табелата се уредливи — внесете износ каде и да е.</p>

        <!-- Табела -->
        <div class="mt-2" aria-live="polite">
            <div
                v-for="row in rows"
                :key="row.id"
                :class="[
                    'flex items-center gap-3 border-b border-border py-2',
                    row.kind === 'net' ? 'border-b-0 pt-4' : '',
                ]"
            >
                <label
                    :for="'calc-' + row.id"
                    :class="[
                        'flex-1 text-sm sm:text-base',
                        row.kind === 'sum' ? 'font-semibold text-ink' : 'text-ink',
                        row.kind === 'net' ? 'font-display text-lg font-semibold text-brand-orange' : '',
                    ]"
                >
                    {{ row.label }}
                </label>
                <span class="w-14 text-right text-sm tabular-nums text-stone">{{ row.pct ? formatPct(row.pct) : '' }}</span>

                <span
                    v-if="row.kind === 'static'"
                    :id="'calc-' + row.id"
                    class="w-28 px-3 py-2 text-right text-sm font-medium tabular-nums text-stone sm:w-36"
                >
                    {{ formatMkd(SALARY.personal) }}
                </span>
                <input
                    v-else
                    :id="'calc-' + row.id"
                    type="number"
                    inputmode="numeric"
                    min="0"
                    step="1"
                    placeholder="0"
                    :value="display(row.id, row.key)"
                    :class="[
                        inputBase,
                        'w-28 px-3 py-2 text-sm sm:w-36 sm:text-base',
                        row.kind === 'net' ? 'border-brand-orange bg-brand-orange/5 text-lg font-bold text-brand-orange' : '',
                    ]"
                    @input="onInput(row.id, row.key, $event)"
                    @blur="onBlur"
                />
                <span class="hidden w-9 text-sm text-stone sm:inline">МКД</span>
            </div>
        </div>

        <!-- PDF копче -->
        <button
            type="button"
            :disabled="!gross || pdfLoading"
            class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-orange px-7 py-3.5 font-semibold text-white transition hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-40"
            @click="downloadPdf"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" />
            </svg>
            {{ pdfLoading ? 'Се генерира…' : 'Преземи PDF' }}
        </button>
        <p v-if="pdfError" class="mt-3 text-sm text-brand-orange-dark" role="alert">{{ pdfError }}</p>

        <!-- Распределба -->
        <div class="mt-8 flex h-2.5 overflow-hidden rounded-full bg-border" aria-hidden="true">
            <div class="h-full bg-brand-orange" :style="{ width: barPct.net + '%' }" />
            <div class="h-full bg-ink" :style="{ width: barPct.contrib + '%' }" />
            <div class="h-full bg-stone/40" :style="{ width: barPct.tax + '%' }" />
        </div>
        <div class="mt-2 flex flex-wrap gap-x-5 gap-y-1 text-xs text-stone">
            <span class="flex items-center gap-1.5"><i class="inline-block h-2 w-2 rounded-full bg-brand-orange" />Нето</span>
            <span class="flex items-center gap-1.5"><i class="inline-block h-2 w-2 rounded-full bg-ink" />Придонеси</span>
            <span class="flex items-center gap-1.5"><i class="inline-block h-2 w-2 rounded-full bg-stone/40" />Данок</span>
        </div>

        <p class="mt-6 text-xs leading-relaxed text-stone">
            Пресметката е информативна и се однесува на редовна месечна плата. Не се применуваат минимална и максимална основица за придонеси.
            Поради заокружување на цели денари, при внес на мал износ (на пр. придонес за невработеност) можни се мали отстапувања во бруто износот.
        </p>
    </div>
</template>
