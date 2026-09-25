@extends('frontend.layouts.main')

@section('title', 'Kualitas Lingkungan - Indeks Lingkungan Kalimantan Barat')
@section('meta_description', 'Data indeks kualitas air, tutupan lahan, dan udara kabupaten/kota di Kalimantan Barat.')

@section('content')
<section class="border-b border-slate-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 pb-10 pt-12 text-center sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">KUALITAS LINGKUNGAN</span>
        <h1 class="mx-auto mt-5 max-w-4xl text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            <span class="text-emerald-500">Indeks Kualitas Lingkungan:</span> Pantau Air, Tutupan Lahan, dan Udara
        </h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm leading-6 text-slate-600">
            Ringkasan indeks lingkungan lintas kabupaten/kota yang dimuat bertahap agar tetap cepat meskipun mencakup data beberapa tahun.
        </p>
    </div>
</section>

<section
    class="bg-slate-50 py-8 sm:py-12"
    x-data="kualitasLingkunganDashboard({
        regions: @js($dashboard['regions']),
        year: @js($year),
        endpointTemplate: @js(route('kualitas-lingkungan.region', ['regency' => '__REGION__']))
    })"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @include('frontend.partials.program_action_toolbar', ['activeFeature' => 'kualitas-lingkungan'])

        <p class="mt-6 text-sm font-semibold text-[#009F6E]">Data diperbarui setiap 6 bulan · Detail wilayah dimuat saat dibuka</p>

        <div class="mt-4 space-y-3">
            <template x-for="region in filteredRegions()" :key="region.id">
                <article class="overflow-hidden rounded-xl border-[0.5px] bg-white transition" :class="openRegionId === region.id ? 'border-[#009F6E]' : 'border-slate-400'">
                    <button type="button" @click="toggleRegion(region)" class="flex w-full items-center gap-3 px-4 py-4 text-left sm:px-5" :aria-expanded="openRegionId === region.id">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-md bg-[#009F6E] text-white"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                        <strong class="min-w-0 flex-1 text-base font-bold text-slate-900" x-text="region.name"></strong>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform" :class="openRegionId === region.id ? 'rotate-180' : ''" aria-hidden="true"></i>
                    </button>

                    <div x-show="openRegionId === region.id" x-cloak class="px-4 pb-5 sm:px-5 sm:pb-6">
                        <div x-show="loadingRegionId === region.id" class="grid animate-pulse gap-5 border-t border-slate-100 pt-5 md:grid-cols-3" aria-live="polite">
                            <template x-for="placeholder in 3" :key="placeholder"><div class="h-36 rounded-lg bg-slate-100"></div></template>
                        </div>

                        <div x-show="errors[region.id]" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <span x-text="errors[region.id]"></span>
                            <button type="button" @click="loadRegion(region, true)" class="ml-2 font-bold underline">Coba lagi</button>
                        </div>

                        <template x-if="regionData[region.id] && loadingRegionId !== region.id">
                            <div class="border-t border-slate-100 pt-5">
                                <div class="grid gap-5 md:grid-cols-3">
                                    <template x-for="index in regionData[region.id].indexes" :key="index.id">
                                        <article class="rounded-lg border border-slate-300 bg-white p-5 sm:p-6">
                                            <div class="flex items-start gap-4">
                                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#009F6E]"><i :class="indexIcon(index.name)" aria-hidden="true"></i></span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500" x-text="`Indeks ${index.label}`"></p>
                                                    <p class="mt-2 text-3xl font-extrabold leading-tight tracking-tight text-slate-900" x-text="formatScore(index.value)"></p>
                                                    <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#009F6E]" x-text="`${regionData[region.id].previous_year}: ${formatScore(index.previous_value)}`"></span>
                                                </div>
                                            </div>
                                        </article>
                                    </template>
                                </div>

                                <div class="mt-14">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                                        <h3 class="text-base font-bold text-[#008f68]">Tren Skor IKLH</h3>
                                        <div class="flex items-center gap-2 text-xs text-slate-500">
                                            <label class="rounded-md border border-slate-200 bg-white px-2 py-1">
                                                <span class="sr-only">Tahun awal grafik</span>
                                                <select x-model.number="rangeFrom" @change="changeRange('from')" class="bg-transparent focus:outline-none">
                                                    @foreach($chartYears as $chartYear)
                                                        <option value="{{ $chartYear }}">{{ $chartYear }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <span>Sampai</span>
                                            <label class="rounded-md border border-slate-200 bg-white px-2 py-1">
                                                <span class="sr-only">Tahun akhir grafik</span>
                                                <select x-model.number="rangeTo" @change="changeRange('to')" class="bg-transparent focus:outline-none">
                                                    @foreach($chartYears as $chartYear)
                                                        <option value="{{ $chartYear }}">{{ $chartYear }}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <span class="hidden sm:inline">· Maks. 5 Tahun</span>
                                        </div>
                                    </div>

                                    <div class="mt-5 overflow-x-auto pb-2">
                                        <div :id="'kualitas-chart-' + region.id" class="min-w-[680px]" aria-label="Grafik tren indeks kualitas lingkungan"></div>
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
    window.kualitasLingkunganDashboard = function (config) {
        return {
            regions: config.regions,
            year: Number(config.year),
            endpointTemplate: config.endpointTemplate,
            rangeFrom: Math.max(2000, Number(config.year) - 4),
            rangeTo: Number(config.year),
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

            changeRange(changed) {
                if (this.rangeFrom > this.rangeTo) {
                    if (changed === 'from') this.rangeTo = this.rangeFrom;
                    else this.rangeFrom = this.rangeTo;
                }

                if (this.rangeTo - this.rangeFrom > 4) {
                    if (changed === 'from') this.rangeTo = this.rangeFrom + 4;
                    else this.rangeFrom = this.rangeTo - 4;
                }

                if (!this.openRegionId) return;
                const region = this.regions.find(item => item.id === this.openRegionId);
                if (!region) return;
                delete this.regionData[region.id];
                this.destroyChart(region.id);
                this.loadRegion(region, true);
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
                    const params = new URLSearchParams({ year: this.year, from_year: this.rangeFrom, to_year: this.rangeTo });
                    const response = await fetch(`${endpoint}?${params}`, {
                        headers: { 'Accept': 'application/json' },
                        signal: this.requestController.signal,
                    });

                    if (!response.ok) throw new Error('Data kualitas lingkungan wilayah belum dapat dimuat.');
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
                const element = document.getElementById(`kualitas-chart-${regionId}`);
                if (!data || !element || typeof window.loadApexCharts !== 'function') return;

                const ApexCharts = await window.loadApexCharts();
                if (this.openRegionId !== regionId || !document.body.contains(element)) return;

                this.destroyChart(regionId);
                this.charts[regionId] = new ApexCharts(element, {
                    chart: { type: 'bar', height: 350, toolbar: { show: false }, animations: { enabled: true, speed: 350 }, fontFamily: 'Inter, sans-serif' },
                    series: data.series.map(series => ({ name: series.name, data: series.data.map(Number) })),
                    colors: ['#064E3B', '#737373', '#009F6E'],
                    plotOptions: { bar: { borderRadius: 0, columnWidth: '54%' } },
                    dataLabels: { enabled: false },
                    grid: { borderColor: '#cbd5e1', strokeDashArray: 4 },
                    xaxis: {
                        categories: data.labels,
                        labels: { style: { fontSize: '11px', colors: '#64748b' } },
                        axisBorder: { color: '#cbd5e1' },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        min: 0,
                        max: 100,
                        tickAmount: 10,
                        labels: { formatter: value => this.formatScore(value) },
                        title: { text: 'Skor Indeks', style: { color: '#64748b', fontSize: '11px' } },
                    },
                    tooltip: { y: { formatter: value => this.formatScore(value) } },
                    legend: { position: 'bottom', horizontalAlign: 'center', markers: { size: 7 } },
                    noData: { text: 'Belum ada data indeks lingkungan' },
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

            indexIcon(name) {
                const normalized = name.toLocaleLowerCase('id-ID');
                if (normalized.includes('tutupan')) return 'fa-solid fa-tree';
                if (normalized.includes('udara')) return 'fa-solid fa-cloud-sun';
                return 'fa-solid fa-water';
            },

            formatScore(value) {
                return new Intl.NumberFormat('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(value || 0));
            },
        };
    };
</script>
@endpush
