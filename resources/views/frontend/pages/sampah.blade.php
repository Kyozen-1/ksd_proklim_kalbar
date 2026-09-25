@extends('frontend.layouts.main')

@section('title', 'Sampah - Pengelolaan Sampah Kalimantan Barat')
@section('meta_description', 'Data timbulan, komposisi, pengelolaan sampah, dan jumlah penduduk kabupaten/kota di Kalimantan Barat.')

@section('content')
<section class="border-b border-slate-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 pb-10 pt-12 text-center sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">SAMPAH</span>
        <h1 class="mx-auto mt-5 max-w-4xl text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            <span class="text-emerald-500">Pengelolaan Sampah:</span> Pantau Timbulan dan Sampah Terkelola
        </h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm leading-6 text-slate-600">
            Ringkasan timbulan harian dan tahunan, komposisi sampah, jumlah penduduk, serta tren pengelolaan sampah kabupaten/kota di Kalimantan Barat.
        </p>
    </div>
</section>

<section
    class="bg-slate-50 py-8 sm:py-12"
    x-data="sampahDashboard({
        regions: @js($dashboard['regions']),
        year: @js($year),
        endpointTemplate: @js(route('sampah.region', ['regency' => '__REGION__']))
    })"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @include('frontend.partials.program_action_toolbar', ['activeFeature' => 'sampah'])

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
                        <div x-show="loadingRegionId === region.id" class="grid animate-pulse gap-4 border-t border-slate-100 pt-4 md:grid-cols-3" aria-live="polite">
                            <template x-for="placeholder in 6" :key="placeholder"><div class="h-32 rounded-lg bg-slate-100"></div></template>
                        </div>

                        <div x-show="errors[region.id]" class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                            <span x-text="errors[region.id]"></span>
                            <button type="button" @click="loadRegion(region, true)" class="ml-2 font-bold underline">Coba lagi</button>
                        </div>

                        <template x-if="regionData[region.id] && loadingRegionId !== region.id">
                            <div class="border-t border-slate-100 pt-5">
                                <div class="grid gap-5 md:grid-cols-3">
                                    <template x-for="card in headlineCards(regionData[region.id])" :key="card.label">
                                        <article class="rounded-lg border border-slate-300 bg-white p-5 sm:p-6">
                                            <div class="flex items-start gap-4">
                                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#009F6E]"><i :class="card.icon" aria-hidden="true"></i></span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500" x-text="card.label"></p>
                                                    <p class="mt-2 text-2xl font-extrabold leading-tight tracking-tight text-slate-900" x-text="card.value"></p>
                                                    <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#009F6E]" x-text="`${regionData[region.id].previous_year}: ${card.previousValue}`"></span>
                                                </div>
                                            </div>
                                        </article>
                                    </template>
                                </div>

                                <div class="mt-5 grid gap-5 md:grid-cols-3">
                                    <template x-for="category in regionData[region.id].summary.categories" :key="category.id">
                                        <article class="rounded-lg border border-slate-300 bg-white p-5 sm:p-6">
                                            <div class="flex items-start gap-4">
                                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#009F6E]"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500" x-text="`Rata-rata Sampah ${category.name}`"></p>
                                                    <p class="mt-2 text-2xl font-extrabold leading-tight tracking-tight text-slate-900" x-text="formatTon(category.total, 'ton/tahun')"></p>
                                                    <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#009F6E]" x-text="`${regionData[region.id].previous_year}: ${formatTon(category.previous_total, 'ton/tahun')}`"></span>
                                                </div>
                                            </div>
                                        </article>
                                    </template>
                                </div>

                                <div class="mt-14">
                                    <h3 class="text-base font-bold text-[#008f68]">Jumlah Sampah Terkelola &amp; Tidak Terkelola</h3>
                                    <div class="mt-5 grid gap-5 md:grid-cols-2">
                                        <template x-for="card in managementCards(regionData[region.id])" :key="card.label">
                                            <article class="rounded-lg border border-slate-300 bg-white p-5 sm:p-6">
                                                <div class="flex items-start gap-4">
                                                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#009F6E]"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></span>
                                                    <div class="min-w-0">
                                                        <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500" x-text="card.label"></p>
                                                        <p class="mt-2 text-2xl font-extrabold leading-tight tracking-tight text-slate-900" x-text="card.value"></p>
                                                        <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#009F6E]" x-text="`${regionData[region.id].previous_year}: ${card.previousValue}`"></span>
                                                    </div>
                                                </div>
                                            </article>
                                        </template>
                                    </div>
                                </div>

                                <div class="mt-14">
                                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                                        <h3 class="text-base font-bold text-[#008f68]">Tren Timbulan Sampah Tahunan</h3>
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
                                        <div :id="'sampah-chart-' + region.id" class="min-w-[640px]" aria-label="Grafik timbulan sampah tahunan"></div>
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
    window.sampahDashboard = function (config) {
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
                    const params = new URLSearchParams({
                        year: this.year,
                        from_year: this.rangeFrom,
                        to_year: this.rangeTo,
                    });
                    const response = await fetch(`${endpoint}?${params}`, {
                        headers: { 'Accept': 'application/json' },
                        signal: this.requestController.signal,
                    });

                    if (!response.ok) throw new Error('Data sampah wilayah belum dapat dimuat.');
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
                const element = document.getElementById(`sampah-chart-${regionId}`);
                if (!data || !element || typeof window.loadApexCharts !== 'function') return;

                const ApexCharts = await window.loadApexCharts();
                if (this.openRegionId !== regionId || !document.body.contains(element)) return;

                this.destroyChart(regionId);
                this.charts[regionId] = new ApexCharts(element, {
                    chart: { type: 'bar', height: 330, toolbar: { show: false }, animations: { enabled: true, speed: 350 }, fontFamily: 'Inter, sans-serif' },
                    series: [{ name: 'Timbulan Sampah', data: data.values.map(Number) }],
                    colors: ['#009F6E'],
                    plotOptions: { bar: { borderRadius: 0, columnWidth: '36%' } },
                    dataLabels: { enabled: false },
                    grid: { borderColor: '#cbd5e1', strokeDashArray: 4 },
                    xaxis: {
                        categories: data.labels,
                        labels: { style: { fontSize: '11px', colors: '#64748b' } },
                        axisBorder: { color: '#cbd5e1' },
                        axisTicks: { show: false },
                    },
                    yaxis: {
                        labels: { formatter: value => this.formatNumber(value) },
                        title: { text: 'Ton', style: { color: '#64748b', fontSize: '11px' } },
                    },
                    tooltip: { y: { formatter: value => this.formatTon(value, 'ton') } },
                    noData: { text: 'Belum ada data timbulan sampah' },
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

            headlineCards(data) {
                return [
                    {
                        label: 'Rata-rata Sampah Harian',
                        value: this.formatTon(data.summary.daily_waste, 'ton/hari'),
                        previousValue: this.formatTon(data.summary.previous_daily_waste, 'ton/hari'),
                        icon: 'fa-solid fa-trash-can',
                    },
                    {
                        label: 'Rata-rata Sampah Tahunan',
                        value: this.formatTon(data.summary.annual_waste, 'ton/tahun'),
                        previousValue: this.formatTon(data.summary.previous_annual_waste, 'ton/tahun'),
                        icon: 'fa-solid fa-trash-can',
                    },
                    {
                        label: 'Jumlah Penduduk',
                        value: `${this.formatNumber(data.summary.population)} jiwa`,
                        previousValue: `${this.formatNumber(data.summary.previous_population)} jiwa`,
                        icon: 'fa-solid fa-people-group',
                    },
                ];
            },

            managementCards(data) {
                return [
                    {
                        label: 'Jumlah Sampah Terkelola',
                        value: this.formatTon(data.summary.managed_waste, 'ton/tahun'),
                        previousValue: this.formatTon(data.summary.previous_managed_waste, 'ton/tahun'),
                    },
                    {
                        label: 'Jumlah Sampah Tidak Terkelola',
                        value: this.formatTon(data.summary.unmanaged_waste, 'ton/tahun'),
                        previousValue: this.formatTon(data.summary.previous_unmanaged_waste, 'ton/tahun'),
                    },
                ];
            },

            formatTon(value, unit) {
                return `${this.formatDecimal(value)} ${unit}`;
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
