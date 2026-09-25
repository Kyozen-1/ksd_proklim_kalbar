@php
    $features = [
        ['key' => 'proklim', 'label' => 'PROKLIM', 'route' => 'proklim'],
        ['key' => 'igrk', 'label' => 'IGRK', 'route' => 'igrk'],
        ['key' => 'sampah', 'label' => 'Sampah', 'route' => 'sampah'],
        ['key' => 'kualitas-lingkungan', 'label' => 'Kualitas Lingkungan', 'route' => 'kualitas-lingkungan'],
        ['key' => 'lb3', 'label' => 'LB3', 'route' => 'lb3'],
    ];
@endphp

<div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="grid gap-3 xl:grid-cols-[minmax(18rem,1fr)_auto_auto] xl:items-center">
        <label class="relative block min-w-0">
            <span class="sr-only">Cari kabupaten atau kota</span>
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400" aria-hidden="true"></i>
            <input
                x-model.debounce.300ms="search"
                type="search"
                placeholder="Cari Kabupaten / Kota..."
                class="w-full rounded-xl border border-slate-200 py-3 pl-11 pr-4 text-sm focus:border-emerald-500 focus:outline-none"
            >
        </label>

        <nav class="overflow-x-auto rounded-xl bg-slate-50 p-1" aria-label="Pilih fitur Program dan Aksi">
            <div class="flex min-w-max items-center gap-1">
                @foreach($features as $feature)
                    @php($isActive = $activeFeature === $feature['key'])
                    <a
                        href="{{ route($feature['route'], ['year' => $year]) }}"
                        @if($isActive) aria-current="page" @endif
                        @class([
                            'whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1',
                            'bg-emerald-500 text-white shadow-sm' => $isActive,
                            'text-slate-700 hover:bg-white hover:text-emerald-700' => !$isActive,
                        ])
                    >
                        {{ $feature['label'] }}
                    </a>
                @endforeach
            </div>
        </nav>

        <a href="{{ route('data') }}" class="inline-flex items-center justify-center gap-3 rounded-xl bg-emerald-800 px-5 py-3 text-sm font-bold text-white shadow-sm transition hover:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <span>Peta Persebaran</span>
            <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
        </a>
    </div>
</div>
