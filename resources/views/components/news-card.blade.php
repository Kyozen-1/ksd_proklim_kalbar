@props([
    'title' => '',
    'category' => 'Berita',
    'date' => '',
    'summary' => '',
    'image' => ''
])

<article class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm card-hover flex flex-col group">
    <div class="relative h-48 overflow-hidden bg-slate-100">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        <div class="absolute top-4 left-4">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-600 text-white shadow-sm">
                {{ $category }}
            </span>
        </div>
    </div>
    <div class="p-6 flex-grow flex flex-col justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-400 mb-2">
                <i class="fa-regular fa-calendar-check text-emerald-600"></i>
                <span>{{ $date }}</span>
            </div>
            <h3 class="text-lg font-bold text-slate-900 leading-snug group-hover:text-emerald-700 transition-colors mb-2">
                {{ $title }}
            </h3>
            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed">
                {{ $summary }}
            </p>
        </div>
        <div class="pt-4 mt-4 border-t border-slate-100 flex items-center text-sm font-semibold text-emerald-700 group-hover:text-emerald-800">
            <span>Baca Selengkapnya</span>
            <i class="fa-solid fa-arrow-right text-xs ml-2 group-hover:translate-x-1 transition-transform"></i>
        </div>
    </div>
</article>
