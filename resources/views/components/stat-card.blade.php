@props([
    'title' => '',
    'value' => '0',
    'icon' => 'fa-leaf',
    'badge' => null
])

<div class="bg-white/90 backdrop-blur-md rounded-2xl p-6 border border-slate-100 shadow-sm card-hover flex flex-col justify-between">
    <div class="flex items-center justify-between mb-4">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl font-bold">
            <i class="fa-solid {{ $icon }}"></i>
        </div>
        @if($badge)
            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                {{ $badge }}
            </span>
        @endif
    </div>
    <div>
        <h3 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-1">{{ $value }}</h3>
        <p class="text-sm font-medium text-slate-500">{{ $title }}</p>
    </div>
</div>
