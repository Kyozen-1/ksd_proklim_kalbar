<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'regencies';
    protected $guarded = 'id';

    public function kegiatan()
    {
        return $this->hasMany('App\Models\Kegiatan', 'kabupaten_kota_id');
    }

    public function data_proklim()
    {
        return $this->hasMany('App\Models\DataProklim', 'kabupaten_kota_id');
    }

    public function data_emisi()
    {
        return $this->hasMany('App\Models\DataEmisi', 'kabupaten_kota_id');
    }

    public function target_penurunan_emisi()
    {
        return $this->hasMany('App\Models\TargetPenurunanEmisi', 'kabupaten_kota_id');
    }

    public function data_sampah()
    {
        return $this->hasMany('App\Models\DataSampah', 'kabupaten_kota_id');
    }

    public function jumlah_penduduk()
    {
        return $this->hasMany('App\Models\JumlahPenduduk', 'kabupaten_kota_id');
    }

    public function data_kualitas_lingkungan()
    {
        return $this->hasMany('App\Models\DataKualitasLingkungan', 'kabupaten_kota_id');
    }

    public function data_timbulan_lb3()
    {
        return $this->hasMany('App\Models\DataTimbulanLb3', 'kabupaten_kota_id');
    }

    public function kecamatan()
    {
        return $this->hasMany('App\Models\District', 'regency_id');
    }
}
