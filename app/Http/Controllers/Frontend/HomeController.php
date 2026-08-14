<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function index()
    {
        $stats = [
            'total_lokasi' => 148,
            'kategori_utama' => 32,
            'penurunan_emisi' => '12.4K Ton CO2e',
            'kabupaten_kota' => 14,
        ];

        $latestNews = [
            [
                'title' => 'Aksi Adaptasi Perubahan Iklim di Desa Mandiri Kalimantan Barat',
                'category' => 'Adaptasi',
                'date' => '05 Aug 2026',
                'summary' => 'Masyarakat pedesaan di Kalbar secara aktif mengembangkan embung air dan penanaman pohon mangrove.',
                'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'title' => 'Penetapan Kampung Iklim Kategori Utama Tahun 2026',
                'category' => 'Penghargaan',
                'date' => '28 Jul 2026',
                'summary' => 'Dinas LHK Kalimantan Barat memberikan apresiasi tinggi kepada 15 lokasi Proklim berprestasi.',
                'image' => 'https://images.unsplash.com/photo-1511497584788-8767611136f6?q=80&w=800&auto=format&fit=crop'
            ],
            [
                'title' => 'Inovasi Mitigasi Gas Rumah Kaca Berbasis Masyarakat Local',
                'category' => 'Mitigasi',
                'date' => '14 Jul 2026',
                'summary' => 'Pengolahan limbah organik menjadi biogas pengganti bahan bakar LPG di Kabupaten Kubu Raya.',
                'image' => 'https://images.unsplash.com/photo-1497435334941-8c899ee9e8e9?q=80&w=800&auto=format&fit=crop'
            ],
        ];

        return view('frontend.pages.home', compact('stats', 'latestNews'));
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function edukasi()
    {
        return view('frontend.pages.edukasi');
    }

    public function data()
    {
        return view('frontend.pages.data');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function pslb3pp()
    {
        return view('frontend.pages.about');
    }

    public function regulasi()
    {
        return view('frontend.pages.regulasi');
    }

    public function berita()
    {
        return view('frontend.pages.berita');
    }

    public function beritaDetail()
    {
        return view('frontend.pages.berita_detail');
    }

    public function galeri()
    {
        return view('frontend.pages.galeri');
    }

    public function faq()
    {
        return view('frontend.pages.faq');
    }

    public function laporan()
    {
        return view('frontend.pages.laporan');
    }

    public function aksiLingkungan()
    {
        return view('frontend.pages.aksi_lingkungan');
    }

    public function aksiLingkunganDetail()
    {
        return view('frontend.pages.aksi_lingkungan_detail');
    }
}
