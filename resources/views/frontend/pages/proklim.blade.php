@extends('frontend.layouts.main')

@section('title', 'PROKLIM - Program Kampung Iklim Kalimantan Barat')
@section('meta_description', 'Data Program Kampung Iklim, serapan karbon, reduksi emisi, dan persebaran PROKLIM kabupaten/kota di Kalimantan Barat.')

@section('content')
<section class="bg-white border-b border-slate-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-10 text-center">
        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">PROKLIM</span>
        <h1 class="mx-auto mt-5 max-w-4xl text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900">
            <span class="text-emerald-500">Satu Data Lingkungan:</span> Pantau Program Kampung Iklim Kalimantan Barat
        </h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm leading-6 text-slate-600">
            Ringkasan persebaran lokasi, kategori PROKLIM, serapan karbon, dan reduksi emisi yang dimuat bertahap agar tetap cepat di setiap perangkat.
        </p>
    </div>
</section>

<section
    class="bg-slate-50 py-8 sm:py-12"
    x-data="proklimDashboard({
        regions: @js($dashboard['regions']),
        year: @js($year),
        endpointTemplate: @js(route('proklim.region', ['regency' => '__REGION__']))
    })"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @include('frontend.partials.program_action_toolbar', ['activeFeature' => 'proklim'])

        <div class="mt-6 space-y-3">
            <template x-for="region in filteredRegions()" :key="region.id">
                <article class="overflow-hidden rounded-xl border bg-white transition" :class="openRegionId === region.id ? 'border-[#00a879]' : 'border-slate-200'">
                    <button
                        type="button"
                        @click="toggleRegion(region)"
                        class="flex w-full items-center gap-3 px-4 py-4 text-left sm:px-5"
                        :aria-expanded="openRegionId === region.id"
                    >
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#00a879] text-white"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                        <span class="min-w-0 flex-1">
                            <strong class="text-base font-bold text-slate-900" x-text="region.name"></strong>
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform" :class="openRegionId === region.id ? 'rotate-180' : ''" aria-hidden="true"></i>
                    </button>

                    <div x-show="openRegionId === region.id" x-cloak class="px-4 pb-5 sm:px-5 sm:pb-6">
                        <div x-show="loadingRegionId === region.id" class="grid animate-pulse gap-4 sm:grid-cols-3" aria-live="polite">
                            <template x-for="placeholder in 3" :key="placeholder"><div class="h-24 rounded-xl bg-slate-100"></div></template>
                        </div>

                        <div x-show="errors[region.id]" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <span x-text="errors[region.id]"></span>
                            <button type="button" @click="loadRegion(region, true)" class="ml-2 font-bold underline">Coba lagi</button>
                        </div>

                        <template x-if="regionData[region.id] && loadingRegionId !== region.id">
                            <div class="border-t border-slate-100 pt-4">
                                <div class="grid gap-4 md:grid-cols-3">
                                    <template x-for="card in summaryCards(regionData[region.id])" :key="card.label">
                                        <article class="min-h-36 rounded-lg border border-slate-200 bg-white p-4">
                                            <div class="flex items-start gap-3">
                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#00a879]"><i :class="card.icon" aria-hidden="true"></i></span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500" x-text="card.label"></p>
                                                    <p class="mt-1 text-3xl font-extrabold leading-none tracking-tight text-slate-900" x-text="card.value"></p>
                                                    <span class="mt-3 inline-flex rounded-full border border-emerald-400 px-2.5 py-1 text-xs font-medium text-[#00a879]" x-text="`${year}: ${card.yearValue}`"></span>
                                                </div>
                                            </div>
                                        </article>
                                    </template>
                                </div>

                                <div class="mt-4 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                    <template x-for="category in regionData[region.id].summary.categories" :key="category.id">
                                        <article class="min-h-36 rounded-lg border border-slate-200 bg-white p-4">
                                            <div class="flex items-start gap-3">
                                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#00a879]"><i class="fa-solid fa-house" aria-hidden="true"></i></span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500" x-text="'Total Sebaran PROKLIM Kategori ' + category.name"></p>
                                                    <p class="mt-1 text-2xl font-extrabold leading-none text-slate-900" x-text="formatNumber(category.total) + ' Titik'"></p>
                                                    <span class="mt-3 inline-flex rounded-full border border-emerald-400 px-2.5 py-1 text-xs font-medium text-[#00a879]" x-text="`${year}: ${formatNumber(category.year_total)} Titik`"></span>
                                                </div>
                                            </div>
                                        </article>
                                    </template>
                                </div>

                                <div class="mt-14">
                                    <div class="flex items-center justify-between gap-4">
                                        <h3 class="text-base font-bold text-[#008f68]">Jumlah Kampung Iklim</h3>
                                        <label class="rounded-md border border-slate-200 bg-white px-2 py-1">
                                            <span class="sr-only">Tahun grafik</span>
                                            <select x-model.number="year" @change="changeYear()" class="bg-transparent text-xs text-slate-500 focus:outline-none">
                                                @foreach($years as $availableYear)
                                                    <option value="{{ $availableYear }}">{{ $availableYear }}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </div>

                                    <div x-show="regionData[region.id].chart.labels.length === 0" class="mt-5 rounded-xl bg-slate-50 p-5 text-center text-sm text-slate-500">Belum ada data kecamatan.</div>
                                    <div x-show="regionData[region.id].chart.labels.length > 0" class="mt-5 overflow-x-auto pb-2">
                                        <div :id="'proklim-chart-' + region.id" class="min-w-[640px]" aria-label="Grafik jumlah Kampung Iklim per kecamatan"></div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </article>
            </template>

            <div x-show="filteredRegions().length === 0" x-cloak class="rounded-2xl border border-slate-200 bg-white p-8 text-center text-sm text-slate-500">
                Kabupaten/kota tidak ditemukan.
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>[x-cloak] { display: none !important; }</style>
<script>
    window.proklimDashboard = function (config) {
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

                    if (!response.ok) throw new Error('Data wilayah belum dapat dimuat.');
                    this.regionData[region.id] = await response.json();
                    this.$nextTick(() => this.renderChart(region.id));
                } catch (error) {
                    if (error.name !== 'AbortError') this.errors[region.id] = error.message;
                } finally {
                    if (this.loadingRegionId === region.id) this.loadingRegionId = null;
                }
            },

            summaryCards(data) {
                return [
                    { label: 'Total Sebaran PROKLIM', value: `${this.formatNumber(data.summary.total_locations)} Titik`, yearValue: `${this.formatNumber(data.summary.locations_in_year)} Titik`, icon: 'fa-solid fa-house' },
                    { label: 'Total Serapan Karbon', value: `${this.formatDecimal(data.summary.carbon_absorption)} tCO₂e`, yearValue: `${this.formatDecimal(data.summary.carbon_absorption_in_year)} tCO₂e`, icon: 'fa-solid fa-sun-plant-wilt' },
                    { label: 'Reduksi Gas Emisi', value: `${this.formatDecimal(data.summary.emission_reduction)} tCO₂e`, yearValue: `${this.formatDecimal(data.summary.emission_reduction_in_year)} tCO₂e`, icon: 'fa-solid fa-wind' },
                ];
            },

            async renderChart(regionId) {
                const data = this.regionData[regionId]?.chart;
                const element = document.getElementById(`proklim-chart-${regionId}`);
                if (!data || !element || data.labels.length === 0 || typeof window.loadApexCharts !== 'function') return;

                const ApexCharts = await window.loadApexCharts();
                if (this.openRegionId !== regionId || !document.body.contains(element)) return;

                this.destroyChart(regionId);
                this.charts[regionId] = new ApexCharts(element, {
                    chart: {
                        type: 'bar',
                        height: 285,
                        toolbar: { show: false },
                        animations: { enabled: true, speed: 350 },
                        fontFamily: 'Inter, sans-serif',
                    },
                    series: [{ name: 'Titik PROKLIM', data: data.values.map(Number) }],
                    colors: ['#059669'],
                    plotOptions: {
                        bar: { borderRadius: 0, columnWidth: '38%', distributed: false },
                    },
                    dataLabels: {
                        enabled: false,
                    },
                    grid: { borderColor: '#e2e8f0', strokeDashArray: 4 },
                    xaxis: {
                        categories: data.labels,
                        labels: { rotate: 0, trim: true, style: { fontSize: '10px', colors: '#64748b' } },
                        axisBorder: { color: '#cbd5e1' },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        min: 0,
                        forceNiceScale: true,
                        labels: { formatter: value => this.formatNumber(value) },
                        title: { text: 'Titik Proklim', style: { color: '#64748b', fontSize: '11px' } },
                    },
                    tooltip: {
                        x: { formatter: value => `${this.year} · ${value}` },
                        y: { formatter: value => `${this.formatNumber(value)} Titik` },
                    },
                    noData: { text: 'Belum ada data kecamatan' },
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
