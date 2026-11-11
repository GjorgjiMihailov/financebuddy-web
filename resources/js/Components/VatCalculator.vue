<script setup>
import { computed, ref } from 'vue'
import { VAT, computeVat, compareRates, formatMoney, buildVatPdfDoc } from '@/Utils/vat'
import { ensurePdfMake, todayString } from '@/Utils/pdf'

const rate = ref(VAT.defaultRate)
// Последното внесено поле + вредност; при промена на стапка се задржува тоа што е внесено
const source = ref({ key: 'net', value: 0 })
const activeId = ref(null)
const raw = ref('')
const pdfLoading = ref(false)
const pdfError = ref('')

const res = computed(() => computeVat(source.value.key, source.value.value, rate.value))
const hasValue = computed(() => res.value.gross > 0)
const comparison = computed(() => (hasValue.value ? compareRates(res.value.net) : []))

const rateOptions = [
    { rate: 5, hint: 'основни производи' },
    { rate: 10, hint: 'угостителство' },
    { rate: 18, hint: 'општа стапка' },
]

const fields = computed(() => [
    { id: 'net', key: 'net', label: 'Износ без ДДВ (нето)' },
    { id: 'vat', key: 'vat', label: `ДДВ (${rate.value}%)` },
    { id: 'gross', key: 'gross', label: 'Износ со ДДВ (бруто)' },
])

function display(id, key) {
    if (activeId.value === id) return raw.value
    if (!hasValue.value) return ''
    return String(res.value[key])
}

function onInput(id, key, event) {
    activeId.value = id
    raw.value = event.target.value
    source.value = { key, value: Math.max(0, parseFloat(raw.value) || 0) }
}

function onBlur() {
    activeId.value = null
}

function setRate(r) {
    activeId.value = null
    rate.value = r
}

async function downloadPdf() {
    if (!hasValue.value || pdfLoading.value) return
    pdfError.value = ''
    pdfLoading.value = true
    const snapshot = { ...res.value }
    const currentRate = rate.value
    try {
        const pdfMake = await ensurePdfMake()
        pdfMake.createPdf(buildVatPdfDoc(snapshot, currentRate, todayString())).download(`presmetka-ddv-${currentRate}.pdf`)
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
        <!-- Избор на стапка -->
        <p class="mb-3 text-xs font-semibold uppercase tracking-wider text-stone">Стапка на ДДВ</p>
        <div class="grid grid-cols-3 gap-3" role="radiogroup" aria-label="Стапка на ДДВ">
            <button
                v-for="option in rateOptions"
                :key="option.rate"
                type="button"
                role="radio"
                :aria-checked="rate === option.rate"
                :class="[
                    'rounded-2xl border-2 px-3 py-3 text-center transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2',
                    rate === option.rate
                        ? 'border-brand-orange bg-brand-orange text-white'
                        : 'border-border bg-white text-ink hover:border-brand-orange',
                ]"
                @click="setRate(option.rate)"
            >
                <span class="block text-xl font-bold sm:text-2xl">{{ option.rate }}%</span>
                <span :class="['mt-0.5 block text-xs', rate === option.rate ? 'text-white/85' : 'text-stone']">{{ option.hint }}</span>
            </button>
        </div>

        <!-- Износи -->
        <div class="mt-8 grid gap-4 sm:grid-cols-3">
            <div v-for="field in fields" :key="field.id">
                <label :for="'vat-' + field.id" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-stone">
                    {{ field.label }}
                </label>
                <div class="flex items-center gap-2">
                    <input
                        :id="'vat-' + field.id"
                        type="number"
                        inputmode="decimal"
                        min="0"
                        step="0.01"
                        placeholder="0"
                        :value="display(field.id, field.key)"
                        :class="[
                            inputBase,
                            'w-full border-2 px-3 py-3 text-xl',
                            field.key === 'gross' ? 'border-brand-orange bg-brand-orange/5 text-brand-orange' : '',
                        ]"
                        @input="onInput(field.id, field.key, $event)"
                        @blur="onBlur"
                    />
                    <span class="text-sm font-medium text-stone">МКД</span>
                </div>
            </div>
        </div>
        <p class="mt-4 text-sm text-stone">
            Внесете износ во кое било од трите полиња — другите две се пресметуваат автоматски. При промена на стапката се задржува последниот внесен износ.
        </p>

        <!-- Споредба на сите ставки -->
        <div v-if="hasValue" class="mt-8">
            <h3 class="font-display text-lg font-semibold text-ink">Истиот износ без ДДВ при сите три стапки</h3>
            <div class="mt-3 overflow-hidden rounded-2xl border border-border">
                <table class="w-full text-sm sm:text-base">
                    <thead class="bg-paper-warm text-stone">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Стапка</th>
                            <th class="px-4 py-3 text-right font-semibold">ДДВ</th>
                            <th class="px-4 py-3 text-right font-semibold">Износ со ДДВ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="row in comparison"
                            :key="row.rate"
                            :class="['border-t border-border', row.rate === rate ? 'bg-brand-orange/5 font-semibold text-brand-orange' : 'text-ink']"
                        >
                            <td class="px-4 py-3">{{ row.rate }}%</td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ formatMoney(row.vat) }}</td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ formatMoney(row.gross) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PDF -->
        <button
            type="button"
            :disabled="!hasValue || pdfLoading"
            class="mt-6 inline-flex items-center gap-2 rounded-full bg-brand-orange px-7 py-3.5 font-semibold text-white transition hover:bg-brand-orange-dark focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-orange focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-40"
            @click="downloadPdf"
        >
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14" />
            </svg>
            {{ pdfLoading ? 'Се генерира…' : 'Преземи PDF' }}
        </button>
        <p v-if="pdfError" class="mt-3 text-sm text-brand-orange-dark" role="alert">{{ pdfError }}</p>

        <p class="mt-6 text-xs leading-relaxed text-stone">
            Пресметката е информативна. Износите се заокружуваат на две децимали. Која стапка важи за конкретна стока или услуга се определува според Законот за данокот на додадена вредност.
        </p>
    </div>
</template>
