@extends('frontend.layouts.main')

@section('title', 'IGRK - Inventaris Gas Rumah Kaca Kalimantan Barat')
@section('meta_description', 'Data Inventaris Gas Rumah Kaca, target penurunan emisi, dan tren emisi sektoral kabupaten/kota di Kalimantan Barat.')

@section('content')
<section class="border-b border-slate-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 pb-10 pt-12 text-center sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">IGRK</span>
        <h1 class="mx-auto mt-5 max-w-4xl text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            <span class="text-emerald-500">Inventaris Gas Rumah Kaca:</span> Pantau Emisi dan Target Penurunan
        </h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm leading-6 text-slate-600">
            Ringkasan inventaris emisi, faktor serapan, aktivitas sektoral, dan target penurunan emisi kabupaten/kota di Kalimantan Barat.
        </p>
    </div>
</section>

<section
    class="bg-slate-50 py-8 sm:py-12"
    x-data="igrkDashboard({
        regions: @js($dashboard['regions']),
        year: @js($year),
        endpointTemplate: @js(route('igrk.region', ['regency' => '__REGION__']))
    })"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @include('frontend.partials.program_action_toolbar', ['activeFeature' => 'igrk'])

        <div class="mt-6 space-y-3">
            <template x-for="region in filteredRegions()" :key="region.id">
                <article class="overflow-hidden rounded-xl border-[0.5px] bg-white transition" :class="openRegionId === region.id ? 'border-[#009F6E]' : 'border-slate-400'">
                    <button type="button" @click="toggleRegion(region)" class="flex w-full items-center gap-3 px-4 py-4 text-left sm:px-5" :aria-expanded="openRegionId === region.id">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#00a879] text-white"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                        <strong class="min-w-0 flex-1 text-base font-bold text-slate-900" x-text="region.name"></strong>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform" :class="openRegionId === region.id ? 'rotate-180' : ''" aria-hidden="true"></i>
                    </button>

                    <div x-show="openRegionId === region.id" x-cloak class="px-4 pb-5 sm:px-5 sm:pb-6">
                        <div x-show="loadingRegionId === region.id" class="grid animate-pulse gap-4 border-t border-slate-100 pt-4 md:grid-cols-3" aria-live="polite">
                            <template x-for="placeholder in 3" :key="placeholder"><div class="h-32 rounded-lg bg-slate-100"></div></template>
                        </div>

                        <div x-show="errors[region.id]" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <span x-text="errors[region.id]"></span>
                            <button type="button" @click="loadRegion(region, true)" class="ml-2 font-bold underline">Coba lagi</button>
                        </div>

                        <template x-if="regionData[region.id] && loadingRegionId !== region.id">
                            <div class="border-t border-slate-100 pt-5">
                                <div class="grid gap-5 md:grid-cols-3">
                                    <article class="rounded-lg border border-slate-400 bg-white p-5 sm:p-6">
                                        <div class="flex items-start gap-4">
                                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#00a879]"><i class="fa-solid fa-wind" aria-hidden="true"></i></span>
                                            <div>
                                                <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500">Total Emisi Tahunan</p>
                                                <p class="mt-2 text-3xl font-extrabold leading-tight text-slate-900" x-text="formatValue(regionData[region.id].summary.net_emission, 'tco2e')"></p>
                                                <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#00a879]" x-text="`${year}: ${formatValue(regionData[region.id].summary.net_emission_in_year, 'tco2e')}`"></span>
                                            </div>
                                        </div>
                                    </article>

                                    <article class="rounded-lg border border-slate-400 bg-white p-5 sm:p-6">
                                        <div class="flex items-start gap-4">
                                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#00a879]"><i class="fa-solid fa-bullseye" aria-hidden="true"></i></span>
                                            <div>
                                                <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500">Target Penurunan Emisi</p>
                                                <p class="mt-2 text-3xl font-extrabold leading-tight text-slate-900" x-text="formatValue(regionData[region.id].summary.target_reduction, 'tco2e')"></p>
                                                <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#00a879]" x-text="`${year}: ${formatValue(regionData[region.id].summary.target_reduction_in_year, 'tco2e')}`"></span>
                                            </div>
                                        </div>
                                    </article>

                                    <article class="rounded-lg border border-emerald-800 bg-[#00a879] p-5 text-white sm:p-6">
                                        <div class="flex items-start gap-4">
                                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-white text-[#00a879]"><i class="fa-solid fa-gauge-high" aria-hidden="true"></i></span>
                                            <div>
                                                <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-emerald-50">Status Kinerja Tahun Ini</p>
                                                <span class="mt-4 inline-flex rounded-full px-3 py-1.5 text-xs font-bold" :class="statusClass(regionData[region.id].summary.performance.tone)" x-text="regionData[region.id].summary.performance.label"></span>
                                                <p class="mt-3 text-xs leading-5 text-emerald-50" x-text="`${formatDecimal(regionData[region.id].summary.performance.progress)}% dari target`"></p>
                                            </div>
                                        </div>
                                    </article>
                                </div>

                                <div class="mt-14">
                                    <h3 class="text-base font-bold text-[#008f68]">Sektor Utama</h3>
                                    <div class="mt-5 grid items-start gap-5 md:grid-cols-2 xl:grid-cols-6">
                                        <template x-for="(sector, sectorIndex) in regionData[region.id].sectors" :key="sector.id">
                                            <article
                                                class="h-fit rounded-lg border border-slate-400 bg-white p-5 sm:p-6"
                                                :class="regionData[region.id].sectors.length % 3 === 2 && sectorIndex >= regionData[region.id].sectors.length - 2 ? 'xl:col-span-3' : 'xl:col-span-2'"
                                            >
                                                <h4 class="text-base font-extrabold leading-6 text-slate-900" x-text="sector.name"></h4>
                                                <div class="mt-4 space-y-4">
                                                    <template x-for="type in sector.types" :key="type.id">
                                                        <div class="rounded-lg border border-slate-300 p-4 sm:p-5">
                                                            <div class="flex items-start gap-4">
                                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#00a879]"><i :class="typeIcon(type)" aria-hidden="true"></i></span>
                                                                <div class="min-w-0">
                                                                    <p class="text-sm font-medium leading-5 text-slate-500" x-text="type.name"></p>
                                                                    <p class="mt-2 text-xl font-extrabold leading-tight text-slate-900" x-text="formatValue(type.total, type.unit)"></p>
                                                                    <span class="mt-3 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#00a879]" x-text="`${year}: ${formatValue(type.year_total, type.unit)}`"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                    <p x-show="sector.types.length === 0" class="rounded-lg bg-slate-50 p-3 text-sm text-slate-500">Belum ada jenis emisi aktif.</p>
                                                </div>
                                            </article>
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-14">
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <h3 class="text-base font-bold text-[#008f68]">Tren Per-Sektor</h3>
                                            <p class="mt-1 text-xs text-slate-500">Hanya nilai dengan satuan tCO₂e yang dijumlahkan.</p>
                                        </div>
                                        <label class="rounded-md border border-slate-200 bg-white px-2 py-1">
                                            <span class="sr-only">Tahun grafik</span>
                                            <select x-model.number="year" @change="changeYear()" class="bg-transparent text-xs text-slate-500 focus:outline-none">
                                                @foreach($years as $availableYear)
                                                    <option value="{{ $availableYear }}">{{ $availableYear }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>

                                    <div x-show="regionData[region.id].chart.labels.length === 0" class="mt-5 rounded-xl bg-slate-50 p-5 text-center text-sm text-slate-500">Belum ada data sektor.</div>
                                    <div x-show="regionData[region.id].chart.labels.length > 0" class="mt-5 overflow-x-auto pb-2">
                                        <div :id="'igrk-chart-' + region.id" class="min-w-[640px]" aria-label="Grafik emisi per sektor"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </article>
            </template>

            <div x-show="filteredRegions().length === 0" x-cloak class="rounded-2xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">Kabupaten/kota tidak ditemukan.</div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>[x-cloak] { display: none !important; }</style>
<script>
    window.igrkDashboard = function (config) {
        return {
            regions: config.regions,
            year: Number(config.year),
            endpointTemplate: config.endpointTemplate,
            search: '',
            openRegionId: null,
            loadingRegionId: null,
            regionData: {},
            errors: {},
            charts: {},
            requestController: null,

            filteredRegions() {
                const needle = this.search.trim().toLocaleLowerCase('id-ID');
                return needle === '' ? this.regions : this.regions.filter(region => region.name.toLocaleLowerCase('id-ID').includes(needle));
            },

            changeYear() {
                const url = new URL(window.location.href);
                url.searchParams.set('year', this.year);
                window.location.assign(url.toString());
            },

            toggleRegion(region) {
                if (this.openRegionId === region.id) {
                    this.openRegionId = null;
                    this.requestController?.abort();
                    this.loadingRegionId = null;
                    this.destroyChart(region.id);
                    return;
                }

                this.destroyAllCharts();
                this.openRegionId = region.id;
                this.loadRegion(region);
            },

            async loadRegion(region, force = false) {
                if (this.regionData[region.id] && !force) {
                    this.$nextTick(() => this.renderChart(region.id));
                    return;
                }

                this.requestController?.abort();
                this.requestController = new AbortController();
                this.loadingRegionId = region.id;
                this.errors[region.id] = null;

                try {
                    const endpoint = this.endpointTemplate.replace('__REGION__', region.id);
                    const response = await fetch(`${endpoint}?year=${this.year}`, {
                        headers: { 'Accept': 'application/json' },
                        signal: this.requestController.signal,
                    });

                    if (!response.ok) throw new Error('Data IGRK wilayah belum dapat dimuat.');
                    this.regionData[region.id] = await response.json();
                    this.$nextTick(() => this.renderChart(region.id));
                } catch (error) {
                    if (error.name !== 'AbortError') this.errors[region.id] = error.message;
                } finally {
                    if (this.loadingRegionId === region.id) this.loadingRegionId = null;
                }
            },

            async renderChart(regionId) {
                const data = this.regionData[regionId]?.chart;
                const element = document.getElementById(`igrk-chart-${regionId}`);
                if (!data || !element || data.labels.length === 0 || typeof window.loadApexCharts !== 'function') return;

                const ApexCharts = await window.loadApexCharts();
                if (this.openRegionId !== regionId || !document.body.contains(element)) return;

                this.destroyChart(regionId);
                this.charts[regionId] = new ApexCharts(element, {
                    chart: { type: 'bar', height: 300, toolbar: { show: false }, animations: { enabled: true, speed: 350 }, fontFamily: 'Inter, sans-serif' },
                    series: [{ name: 'Emisi Bersih', data: data.values.map(Number) }],
                    colors: ['#059669'],
                    plotOptions: { bar: { borderRadius: 0, columnWidth: '38%' } },
                    dataLabels: { enabled: false },
                    grid: { borderColor: '#e2e8f0', strokeDashArray: 4 },
                    xaxis: {
                        categories: data.labels,
                        labels: { rotate: 0, trim: true, style: { fontSize: '10px', colors: '#64748b' } },
                        axisBorder: { color: '#cbd5e1' },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        labels: { formatter: value => this.formatNumber(value) },
                        title: { text: 'Jumlah Emisi (tCO₂e)', style: { color: '#64748b', fontSize: '11px' } },
                    },
                    tooltip: {
                        x: { formatter: value => `${this.year} · ${value}` },
                        y: { formatter: value => this.formatValue(value, 'tco2e') },
                    },
                    noData: { text: 'Belum ada data sektor' },
                });
                this.charts[regionId].render();
            },

            destroyChart(regionId) {
                if (!this.charts[regionId]) return;
                this.charts[regionId].destroy();
                delete this.charts[regionId];
            },

            destroyAllCharts() {
                Object.keys(this.charts).forEach(regionId => this.destroyChart(regionId));
            },

            statusClass(tone) {
                return {
                    good: 'bg-emerald-50 text-emerald-700',
                    warning: 'bg-amber-100 text-amber-700',
                    danger: 'bg-red-100 text-red-700',
                    neutral: 'bg-white/90 text-slate-600',
                }[tone] || 'bg-white/90 text-slate-600';
            },

            typeIcon(type) {
                const name = type.name.toLocaleLowerCase('id-ID');

                if (name.includes('bahan bakar')) return 'fa-solid fa-gas-pump';
                if (name.includes('listrik')) return 'fa-solid fa-bolt';
                if (name.includes('air limbah')) return 'fa-solid fa-water';
                if (name.includes('sampah')) return 'fa-solid fa-recycle';
                if (name.includes('peternakan')) return 'fa-solid fa-cow';
                if (name.includes('pupuk') || name.includes('sawah')) return 'fa-solid fa-seedling';
                if (name.includes('ippu') || name.includes('industri')) return 'fa-solid fa-industry';
                if (name.includes('serapan') || type.calculation === 'kurang') return 'fa-solid fa-leaf';
                if (name.includes('emisi')) return 'fa-solid fa-wind';
                if (type.unit === 'gwh') return 'fa-solid fa-bolt';
                if (type.unit === 'kl') return 'fa-solid fa-gas-pump';
                return 'fa-solid fa-wind';
            },

            formatValue(value, unit) {
                const units = { tco2e: 'tCO₂e', kl: 'KL', gwh: 'GWh' };
                return `${this.formatDecimal(value)} ${units[unit] || unit || ''}`.trim();
            },

            formatNumber(value) {
                return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 0 }).format(Number(value || 0));
            },

            formatDecimal(value) {
                return new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(Number(value || 0));
            },
        };
    };
</script>
@endpush
