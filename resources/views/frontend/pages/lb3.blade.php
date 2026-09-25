@extends('frontend.layouts.main')

@section('title', 'LB3 - Timbulan Limbah B3 Kalimantan Barat')
@section('meta_description', 'Data timbulan Limbah Bahan Berbahaya dan Beracun sektor industri dan fasilitas pelayanan kesehatan di Kalimantan Barat.')

@section('content')
<section class="border-b border-slate-100 bg-white">
    <div class="mx-auto max-w-7xl px-4 pb-10 pt-12 text-center sm:px-6 lg:px-8">
        <span class="inline-flex rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600">LB3</span>
        <h1 class="mx-auto mt-5 max-w-4xl text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl">
            <span class="text-emerald-500">Limbah B3:</span> Pantau Timbulan Sektor Industri dan Fasyankes
        </h1>
        <p class="mx-auto mt-4 max-w-3xl text-sm leading-6 text-slate-600">
            Ringkasan timbulan Limbah Bahan Berbahaya dan Beracun kabupaten/kota yang dimuat saat dibutuhkan agar halaman tetap ringan.
        </p>
    </div>
</section>

<section
    class="bg-slate-50 py-8 sm:py-12"
    x-data="lb3Dashboard({
        regions: @js($dashboard['regions']),
        year: @js($year),
        endpointTemplate: @js(route('lb3.region', ['regency' => '__REGION__']))
    })"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        @include('frontend.partials.program_action_toolbar', ['activeFeature' => 'lb3'])

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
                                    <template x-for="card in summaryCards(regionData[region.id])" :key="card.label">
                                        <article class="rounded-lg border border-slate-300 bg-white p-5 sm:p-6">
                                            <div class="flex items-start gap-4">
                                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-md bg-emerald-50 text-[#009F6E]"><i class="fa-solid fa-trash-can" aria-hidden="true"></i></span>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-semibold uppercase leading-5 tracking-wide text-slate-500" x-text="card.label"></p>
                                                    <p class="mt-2 text-3xl font-extrabold leading-tight tracking-tight text-slate-900" x-text="formatTon(card.value)"></p>
                                                    <span class="mt-4 inline-flex rounded-full border border-emerald-400 px-3 py-1.5 text-xs font-medium text-[#009F6E]" x-text="`${regionData[region.id].previous_year}: ${formatTon(card.previousValue)}`"></span>
                                                </div>
                                            </div>
                                        </article>
                                    </template>
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
    window.lb3Dashboard = function (config) {
        return {
            regions: config.regions,
            year: Number(config.year),
            endpointTemplate: config.endpointTemplate,
            search: '',
            openRegionId: null,
            loadingRegionId: null,
            regionData: {},
            errors: {},
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
                    return;
                }

                this.openRegionId = region.id;
                this.loadRegion(region);
            },

            async loadRegion(region, force = false) {
                if (this.regionData[region.id] && !force) return;

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

                    if (!response.ok) throw new Error('Data LB3 wilayah belum dapat dimuat.');
                    this.regionData[region.id] = await response.json();
                } catch (error) {
                    if (error.name !== 'AbortError') this.errors[region.id] = error.message;
                } finally {
                    if (this.loadingRegionId === region.id) this.loadingRegionId = null;
                }
            },

            summaryCards(data) {
                return [
                    {
                        label: 'Total Timbulan LB3',
                        value: data.summary.total,
                        previousValue: data.summary.previous_total,
                    },
                    ...data.summary.sectors.map(sector => ({
                        label: `Total Timbulan LB3 Sektor ${sector.name}`,
                        value: sector.total,
                        previousValue: sector.previous_total,
                    })),
                ];
            },

            formatTon(value) {
                return `${new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(Number(value || 0))} ton/tahun`;
            },
        };
    };
</script>
@endpush
