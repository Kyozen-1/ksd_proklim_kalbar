import './bootstrap';

let apexChartsPromise;

window.loadApexCharts = function () {
    if (!apexChartsPromise) {
        apexChartsPromise = import('apexcharts').then(module => module.default);
    }

    return apexChartsPromise;
};

let leafletPromise;

window.loadLeaflet = function () {
    if (!leafletPromise) {
        leafletPromise = Promise.all([
            import('leaflet'),
            import('leaflet/dist/leaflet.css'),
        ]).then(([module]) => module.default ?? module);
    }

    return leafletPromise;
};

window.dispatchEvent(new Event('app:loaders-ready'));
