@extends('frontend.layouts.main')

@section('title', 'Peta Persebaran Data Lingkungan Kalimantan Barat')
@section('meta_description', 'Peta interaktif persebaran PROKLIM, IGRK, sampah, kualitas lingkungan, dan LB3 di Kalimantan Barat.')
@section('fullscreen', 'true')

@section('content')
<section
    class="relative h-dvh min-h-[640px] overflow-hidden bg-slate-800"
    x-data="environmentMap({
        features: @js($mapConfig['features']),
        regions: @js($mapConfig['regions']),
        markersEndpoint: @js(route('map.markers')),
        markerEndpointTemplate: @js(route('map.marker', ['mapLocation' => '__MARKER__']))
    })"
>
    <div x-ref="map" class="absolute inset-0 z-0" aria-label="Peta persebaran data lingkungan Kalimantan Barat"></div>

    <div class="pointer-events-none absolute inset-x-0 top-0 z-[500] bg-gradient-to-b from-slate-950/60 via-slate-950/20 to-transparent px-4 pb-12 pt-4 sm:px-6">
        <div class="pointer-events-auto mx-auto grid max-w-7xl gap-2.5 md:grid-cols-2 xl:grid-cols-[minmax(16rem,1fr)_12rem_13rem_auto]">
            <label class="relative block">
                <span class="sr-only">Cari lokasi</span>
                <i class="fa-solid fa-magnifying-glass absolute right-1.5 top-1/2 z-10 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full bg-[#009F6E] text-sm text-white" aria-hidden="true"></i>
                <input x-model="search" @input.debounce.400ms="applyFilters(true)" type="search" placeholder="Cari lokasi..." class="h-12 w-full rounded-full border border-white/50 bg-white/95 py-3 pl-5 pr-12 text-sm shadow-lg backdrop-blur focus:border-emerald-500 focus:outline-none">
            </label>

            <label class="relative block">
                <span class="sr-only">Pilih kabupaten atau kota</span>
                <i class="fa-solid fa-location-crosshairs absolute left-4 top-1/2 -translate-y-1/2 text-slate-500" aria-hidden="true"></i>
                <select x-model="regency" @change="applyFilters(true)" class="h-12 w-full appearance-none rounded-full border border-white/50 bg-white/95 py-3 pl-11 pr-9 text-sm text-slate-700 shadow-lg focus:border-emerald-500 focus:outline-none">
                    <option value="">Kab/Kota</option>
                    <template x-for="region in regions" :key="region.id"><option :value="region.id" x-text="region.name"></option></template>
                </select>
                <i class="fa-solid fa-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400" aria-hidden="true"></i>
            </label>

            <label class="relative block">
                <span class="sr-only">Pilih kategori data</span>
                <i class="fa-solid fa-sliders absolute left-4 top-1/2 -translate-y-1/2 text-slate-500" aria-hidden="true"></i>
                <select x-model="singleFeature" @change="selectSingleFeature()" class="h-12 w-full appearance-none rounded-full border border-white/50 bg-white/95 py-3 pl-11 pr-9 text-sm text-slate-700 shadow-lg focus:border-emerald-500 focus:outline-none">
                    <option value="">Semua Kategori</option>
                    <template x-for="feature in features" :key="feature.key"><option :value="feature.key" x-text="feature.label"></option></template>
                </select>
                <i class="fa-solid fa-chevron-down pointer-events-none absolute right-4 top-1/2 -translate-y-1/2 text-xs text-slate-400" aria-hidden="true"></i>
            </label>

            <button @click="refresh()" type="button" class="flex h-12 items-center justify-center gap-2 rounded-full bg-[#009F6E] px-5 text-sm font-bold text-white shadow-lg transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-white">
                <i class="fa-solid fa-rotate" :class="loading ? 'animate-spin' : ''" aria-hidden="true"></i>
                <span class="xl:hidden">Muat Ulang</span>
            </button>
        </div>
    </div>

    <div x-show="loading" x-cloak class="absolute left-1/2 top-24 z-[550] -translate-x-1/2 rounded-full bg-slate-900/80 px-4 py-2 text-xs font-semibold text-white shadow-lg backdrop-blur">Memuat titik lokasi...</div>

    <div x-show="error" x-cloak class="absolute left-1/2 top-24 z-[550] flex -translate-x-1/2 items-center gap-3 rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-xl">
        <span x-text="error"></span><button type="button" @click="loadMarkers()" class="underline">Coba lagi</button>
    </div>

    <div x-show="truncated" x-cloak class="absolute bottom-24 left-1/2 z-[500] -translate-x-1/2 rounded-full bg-amber-50 px-4 py-2 text-xs font-semibold text-amber-800 shadow-lg">Maksimal 500 titik ditampilkan. Perbesar peta atau gunakan filter.</div>

    <a href="{{ route('proklim') }}" class="absolute bottom-6 left-4 z-[500] inline-flex items-center gap-2 rounded-full bg-emerald-500 px-5 py-3 text-sm font-bold text-white shadow-xl transition hover:bg-emerald-600 sm:left-6">
        <i class="fa-solid fa-arrow-left-long" aria-hidden="true"></i> Kembali
    </a>

    <div x-show="!selected && !detailLoading" class="absolute bottom-20 left-4 z-[500] sm:left-6">
        <button type="button" @click="baseMapOpen = !baseMapOpen" :aria-expanded="baseMapOpen" class="inline-flex h-11 items-center gap-2 rounded-full bg-white/95 px-4 text-sm font-bold text-slate-700 shadow-xl backdrop-blur transition hover:bg-white focus:outline-none focus:ring-2 focus:ring-[#009F6E]" aria-label="Pilih jenis peta">
            <i class="fa-solid fa-layer-group text-[#009F6E]" aria-hidden="true"></i>
            <span x-text="baseMapConfig(activeBaseMap)?.label || 'Jenis Peta'"></span>
            <i class="fa-solid fa-chevron-up text-[10px] text-slate-400" :class="baseMapOpen ? 'rotate-180' : ''" aria-hidden="true"></i>
        </button>

        <div x-show="baseMapOpen" x-cloak @click.outside="baseMapOpen = false" class="absolute bottom-14 left-0 w-52 rounded-2xl bg-white/95 p-2 shadow-2xl backdrop-blur" aria-label="Jenis peta">
            <p class="px-3 pb-1 pt-2 text-[11px] font-bold uppercase tracking-wider text-slate-400">Jenis Peta</p>
            <template x-for="baseMap in baseMaps" :key="baseMap.key">
                <button type="button" @click="switchBaseMap(baseMap.key)" class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-left text-sm transition hover:bg-slate-100" :class="activeBaseMap === baseMap.key ? 'bg-emerald-50 font-bold text-[#009F6E]' : 'text-slate-700'">
                    <i :class="baseMap.icon" class="w-5 text-center" aria-hidden="true"></i>
                    <span x-text="baseMap.label"></span>
                    <i x-show="activeBaseMap === baseMap.key" class="fa-solid fa-check ml-auto text-xs" aria-hidden="true"></i>
                </button>
            </template>
        </div>
    </div>

    <aside class="absolute bottom-6 right-16 z-[500] hidden w-64 rounded-2xl bg-white/95 p-4 shadow-2xl backdrop-blur sm:block" aria-label="Legenda peta">
        <p class="mb-2 text-xs font-bold uppercase tracking-wider text-slate-400">Kategori Data</p>
        <template x-for="feature in features" :key="feature.key">
            <button type="button" @click="toggleFeature(feature.key)" class="flex w-full items-center gap-3 rounded-lg px-2 py-2 text-left text-sm transition hover:bg-slate-100" :class="activeFeatures[feature.key] ? 'text-slate-800' : 'text-slate-400 line-through'">
                <span class="flex h-5 w-5 items-center justify-center" :style="`color: ${feature.color}`"><i class="fa-solid fa-location-dot" aria-hidden="true"></i></span>
                <span class="font-medium" x-text="feature.label"></span>
                <i class="fa-solid fa-check ml-auto text-xs" x-show="activeFeatures[feature.key]" aria-hidden="true"></i>
            </button>
        </template>
        <p class="mt-2 border-t border-slate-100 pt-3 text-xs text-slate-500"><span class="font-bold" x-text="visibleCount"></span> titik pada area peta</p>
    </aside>

    <div x-show="selected || detailLoading" x-cloak class="absolute inset-x-4 bottom-24 z-[600] max-h-[70vh] overflow-y-auto rounded-[1.75rem] bg-white shadow-2xl sm:bottom-auto sm:left-6 sm:right-auto sm:top-24 sm:w-[340px]">
        <div x-show="detailLoading" class="animate-pulse p-5">
            <div class="h-44 rounded-2xl bg-slate-200"></div><div class="mt-5 h-5 w-24 rounded bg-slate-200"></div><div class="mt-4 h-20 rounded bg-slate-100"></div>
        </div>

        <template x-if="selected && !detailLoading">
            <article>
                <div class="relative h-44 overflow-hidden rounded-t-[1.75rem] bg-gradient-to-br from-emerald-700 to-slate-900">
                    <img x-show="selected.image_url" :src="selected.image_url" :alt="selected.title" class="h-full w-full object-cover" x-on:error="selected.image_url = null">
                    <div x-show="!selected.image_url" class="flex h-full items-center justify-center text-5xl text-white/80"><i :class="featureConfig(selected.feature)?.icon || 'fa-solid fa-location-dot'" aria-hidden="true"></i></div>
                    <button type="button" @click="closeDetail()" class="absolute right-3 top-3 flex h-9 w-9 items-center justify-center rounded-full bg-white/95 text-slate-600 shadow-md transition hover:bg-white hover:text-slate-900" aria-label="Tutup detail"><i class="fa-solid fa-xmark" aria-hidden="true"></i></button>
                </div>

                <div class="space-y-4 p-5 sm:p-6">
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-bold text-[#009F6E]" x-text="selected.category || selected.feature_label"></span>
                    <h2 class="text-lg font-extrabold leading-6 text-slate-900" x-text="selected.title"></h2>

                    <div class="flex items-start gap-3 text-sm leading-6 text-slate-700"><i class="fa-regular fa-map mt-1 text-[#009F6E]" aria-hidden="true"></i><p x-text="selected.address || selected.region"></p></div>
                    <div x-show="selected.metric" class="flex items-start gap-3 text-sm leading-6 text-slate-700">
                        <i class="fa-solid fa-circle-info mt-1 text-[#009F6E]" aria-hidden="true"></i>
                        <div><p class="text-xs font-semibold uppercase tracking-wide text-slate-400" x-text="selected.metric?.label"></p><p class="font-semibold" x-text="formatMetric(selected.metric)"></p></div>
                    </div>
                    <div x-show="selected.description" class="flex items-start gap-3 text-sm leading-6 text-slate-700"><i class="fa-regular fa-circle-question mt-1 text-[#009F6E]" aria-hidden="true"></i><p x-text="selected.description"></p></div>
                    <div x-show="selected.additional_info" class="flex items-start gap-3 text-sm leading-6 text-slate-700"><i class="fa-solid fa-list-check mt-1 text-[#009F6E]" aria-hidden="true"></i><p x-text="selected.additional_info"></p></div>
                    <div x-show="selected.source_url" class="flex items-start gap-3 text-sm leading-6 text-slate-600">
                        <i class="fa-solid fa-link mt-1 text-[#009F6E]" aria-hidden="true"></i>
                        <p>Sumber: <a :href="selected.source_url" target="_blank" rel="noopener noreferrer" class="font-semibold text-[#009F6E] underline" x-text="sourceHost(selected.source_url)"></a></p>
                    </div>
                </div>
            </article>
        </template>
    </div>

    <div class="absolute bottom-24 right-4 z-[500] sm:hidden">
        <button type="button" @click="mobileLegendOpen = !mobileLegendOpen" class="flex h-11 w-11 items-center justify-center rounded-full bg-white text-slate-700 shadow-xl" aria-label="Buka legenda"><i class="fa-solid fa-layer-group" aria-hidden="true"></i></button>
        <div x-show="mobileLegendOpen" x-cloak @click.outside="mobileLegendOpen = false" class="absolute bottom-14 right-0 w-60 rounded-2xl bg-white p-3 shadow-2xl">
            <template x-for="feature in features" :key="feature.key">
                <button type="button" @click="toggleFeature(feature.key)" class="flex w-full items-center gap-3 rounded-lg px-2 py-2 text-left text-sm" :class="activeFeatures[feature.key] ? 'text-slate-800' : 'text-slate-400 line-through'">
                    <i class="fa-solid fa-location-dot" :style="`color: ${feature.color}`" aria-hidden="true"></i><span x-text="feature.label"></span>
                </button>
            </template>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<style>
    [x-cloak] { display: none !important; }
    .leaflet-container { font-family: Inter, sans-serif; background: #1e293b; }
    .leaflet-control-attribution { font-size: 9px; }
    .environment-map-marker { background: transparent; border: 0; }
    .environment-map-pin { position: relative; display: flex; width: 30px; height: 30px; align-items: center; justify-content: center; border: 3px solid white; border-radius: 9999px; color: white; background: var(--marker-color); box-shadow: 0 4px 12px rgb(15 23 42 / 45%); }
    .environment-map-pin::after { content: ''; position: absolute; left: 50%; bottom: -7px; width: 9px; height: 9px; background: var(--marker-color); transform: translateX(-50%) rotate(45deg); border-right: 2px solid white; border-bottom: 2px solid white; }
    .environment-map-pin i { position: relative; z-index: 1; font-size: 11px; }
</style>
<script>
    window.environmentMap = function (config) {
        return {
            features: config.features, regions: config.regions, markersEndpoint: config.markersEndpoint, markerEndpointTemplate: config.markerEndpointTemplate,
            map: null, markerLayer: null, baseLayers: {}, activeBaseLayer: null, search: '', regency: '', singleFeature: '',
            baseMaps: [
                { key: 'satellite', label: 'Satelit', icon: 'fa-solid fa-satellite' },
                { key: 'terrain', label: 'Terrain', icon: 'fa-solid fa-mountain-sun' },
                { key: 'street', label: 'Jalan', icon: 'fa-solid fa-road' },
            ],
            activeBaseMap: 'satellite', baseMapOpen: false,
            activeFeatures: Object.fromEntries(config.features.map(feature => [feature.key, true])),
            loading: false, detailLoading: false, error: '', truncated: false, visibleCount: 0, selected: null, mobileLegendOpen: false,
            markerRequest: null, detailRequest: null, moveTimer: null,

            async leaflet() {
                if (typeof window.loadLeaflet !== 'function') {
                    await new Promise((resolve, reject) => {
                        const timeout = window.setTimeout(() => reject(new Error('Leaflet loader tidak tersedia.')), 10000);
                        window.addEventListener('app:loaders-ready', () => {
                            window.clearTimeout(timeout);
                            resolve();
                        }, { once: true });
                    });
                }

                return window.loadLeaflet();
            },

            async init() {
                try {
                    const L = await this.leaflet();
                    this.map = L.map(this.$refs.map, { zoomControl: false, preferCanvas: true, minZoom: 5, maxZoom: 18 }).setView([-0.35, 111.0], 6);
                    this.baseLayers = {
                        satellite: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', { attribution: 'Tiles &copy; Esri', maxZoom: 18 }),
                        terrain: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Topo_Map/MapServer/tile/{z}/{y}/{x}', { attribution: 'Tiles &copy; Esri', maxZoom: 18 }),
                        street: L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', { attribution: 'Tiles &copy; Esri', maxZoom: 18 }),
                    };
                    this.activeBaseLayer = this.baseLayers[this.activeBaseMap].addTo(this.map);
                    L.control.zoom({ position: 'bottomright' }).addTo(this.map);
                    this.markerLayer = L.layerGroup().addTo(this.map);
                    this.map.on('moveend', () => { clearTimeout(this.moveTimer); this.moveTimer = setTimeout(() => this.loadMarkers(), 250); });
                    await this.loadMarkers();
                } catch (error) {
                    console.error('Leaflet map initialization failed:', error);
                    this.error = 'Peta belum dapat dimuat. Periksa koneksi lalu coba lagi.';
                }
            },

            enabledFeatures() { return this.features.filter(feature => this.activeFeatures[feature.key]).map(feature => feature.key); },
            featureConfig(key) { return this.features.find(feature => feature.key === key); },
            baseMapConfig(key) { return this.baseMaps.find(baseMap => baseMap.key === key); },
            switchBaseMap(key) {
                const nextLayer = this.baseLayers[key];
                if (!this.map || !nextLayer || key === this.activeBaseMap) { this.baseMapOpen = false; return; }
                if (this.activeBaseLayer) this.map.removeLayer(this.activeBaseLayer);
                this.activeBaseLayer = nextLayer.addTo(this.map);
                this.activeBaseMap = key;
                this.baseMapOpen = false;
            },
            applyFilters(fitResults = false) { this.closeDetail(); this.loadMarkers(fitResults); },
            selectSingleFeature() {
                this.activeFeatures = Object.fromEntries(this.features.map(feature => [feature.key, this.singleFeature === '' || feature.key === this.singleFeature]));
                this.applyFilters(true);
            },
            toggleFeature(key) {
                this.activeFeatures = { ...this.activeFeatures, [key]: !this.activeFeatures[key] };
                this.singleFeature = '';
                this.applyFilters();
            },
            refresh() {
                this.search = ''; this.regency = ''; this.singleFeature = '';
                this.activeFeatures = Object.fromEntries(this.features.map(feature => [feature.key, true]));
                this.map?.setView([-0.35, 111.0], 6);
                this.applyFilters();
            },

            async loadMarkers(fitResults = false) {
                if (!this.map || !this.markerLayer) return;
                const enabledFeatures = this.enabledFeatures();
                if (enabledFeatures.length === 0) { this.markerLayer.clearLayers(); this.visibleCount = 0; this.truncated = false; return; }

                this.markerRequest?.abort(); this.markerRequest = new AbortController(); this.loading = true; this.error = '';
                const params = new URLSearchParams({ limit: '500' });
                if (!fitResults) {
                    const bounds = this.map.getBounds();
                    params.set('bounds', [bounds.getWest(), bounds.getSouth(), bounds.getEast(), bounds.getNorth()].join(','));
                }
                if (this.search.trim()) params.set('search', this.search.trim());
                if (this.regency) params.set('regency', this.regency);
                enabledFeatures.forEach(feature => params.append('features[]', feature));

                try {
                    const response = await fetch(`${this.markersEndpoint}?${params}`, { headers: { Accept: 'application/json' }, signal: this.markerRequest.signal });
                    if (!response.ok) throw new Error('Data titik lokasi belum dapat dimuat.');
                    const payload = await response.json();
                    await this.renderMarkers(payload.markers, fitResults);
                    this.visibleCount = payload.count; this.truncated = payload.truncated;
                } catch (error) { if (error.name !== 'AbortError') this.error = error.message; }
                finally { this.loading = false; }
            },

            async renderMarkers(markers, fitResults) {
                const L = await this.leaflet(); this.markerLayer.clearLayers(); const points = [];
                markers.forEach(marker => {
                    const feature = this.featureConfig(marker.feature); if (!feature) return;
                    const icon = L.divIcon({ className: 'environment-map-marker', html: `<span class="environment-map-pin" style="--marker-color:${feature.color}"><i class="${feature.icon}"></i></span>`, iconSize: [30, 38], iconAnchor: [15, 37] });
                    const point = [Number(marker.latitude), Number(marker.longitude)];
                    L.marker(point, { icon, title: marker.title, keyboard: true }).on('click', () => this.openDetail(marker.id, point)).addTo(this.markerLayer);
                    points.push(point);
                });
                if (fitResults && points.length > 0) this.map.fitBounds(points, { padding: [70, 70], maxZoom: 12 });
            },

            async openDetail(markerId, point) {
                this.detailRequest?.abort(); this.detailRequest = new AbortController(); this.detailLoading = true; this.selected = null; this.map.panTo(point, { animate: true });
                try {
                    const endpoint = this.markerEndpointTemplate.replace('__MARKER__', markerId);
                    const response = await fetch(endpoint, { headers: { Accept: 'application/json' }, signal: this.detailRequest.signal });
                    if (!response.ok) throw new Error('Detail lokasi belum dapat dimuat.');
                    this.selected = await response.json();
                } catch (error) { if (error.name !== 'AbortError') this.error = error.message; }
                finally { this.detailLoading = false; }
            },
            closeDetail() { this.detailRequest?.abort(); this.selected = null; this.detailLoading = false; },
            formatMetric(metric) {
                if (!metric) return '';
                const value = new Intl.NumberFormat('id-ID', { maximumFractionDigits: 2 }).format(Number(metric.value || 0));
                return `${value} ${metric.unit || ''}`.trim();
            },
            sourceHost(url) { try { return new URL(url).hostname; } catch { return url; } },
        };
    };
</script>
@endpush
