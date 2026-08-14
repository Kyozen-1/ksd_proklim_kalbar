@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard - CMS Proklim Kalbar')

@section('content')
<div class="space-y-6">
    <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-xs space-y-3">
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">Status Ready</span>
        <h1 class="text-2xl font-bold text-slate-900">CMS Admin Panel Setup Complete</h1>
        <p class="text-sm text-slate-600">
            Struktur folder CMS Admin telah disiapkan secara terpisah dari Frontend. Area ini siap untuk pengembangan fitur-fitur kelola data lokasi, verifikasi SRN, dan postingan artikel.
        </p>
        <div class="pt-4">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-bold hover:bg-slate-800">
                <i class="fa-solid fa-eye"></i> Lihat Tampilan Frontend
            </a>
        </div>
    </div>
</div>
@endsection
