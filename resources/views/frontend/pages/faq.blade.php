@extends('frontend.layouts.main')

@section('title', 'Frequently Asked Questions - DLHK Proklim Kalimantan Barat')

@section('content')
<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-10 space-y-12 py-8 sm:py-12">

    <section class="text-center space-y-3 max-w-4xl mx-auto">
        <div class="inline-block">
            <span class="px-4 py-1.5 rounded-full border border-[#7AE3BC]/70 text-[#00A86B] text-[11px] font-extrabold uppercase tracking-widest bg-[#E6F9F2]">
                FAQ
            </span>
        </div>
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-snug">
            Frequently Asked Questions
        </h1>
        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-3xl mx-auto font-normal">
            Menyajikan informasi terkait PSLB3PP, Proklim, dan lain-lain
        </p>
    </section>

    <section class="max-w-5xl mx-auto">
        @if($faqs->count())
            <div x-data="{ activeFaq: {{ $faqs->first()->id }} }" class="space-y-4">
                @foreach($faqs as $faq)
                    <div class="space-y-2">
                        <button @click="activeFaq = activeFaq === {{ $faq->id }} ? null : {{ $faq->id }}"
                                class="w-full flex items-center justify-between p-5 rounded-xl bg-[#E6F9F2] hover:bg-[#d5f5e8] transition-all duration-200 text-left font-bold text-slate-800 text-xs sm:text-sm md:text-base leading-snug cursor-pointer gap-4">
                            <span>{{ $faq->pertanyaan }}</span>
                            <i class="fa-solid text-slate-500 transition-transform duration-200 text-sm"
                               :class="activeFaq === {{ $faq->id }} ? 'fa-chevron-up rotate-180' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="activeFaq === {{ $faq->id }}"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             class="p-5 sm:p-6 text-xs sm:text-sm text-slate-600 leading-relaxed font-normal bg-transparent">
                            {!! nl2br(e($faq->jawaban)) !!}
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-2xl p-8 text-center text-sm text-slate-500">
                Belum ada FAQ aktif yang diterbitkan dari CMS.
            </div>
        @endif
    </section>

</div>
@endsection
