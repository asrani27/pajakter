<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpd extends Model
{
    protected $table = 'skpd';
    protected $guarded = ['id'];
    public $timestamps = false;

    public function pajak($bulan_tahun_id = null)
    {
        $query = $this->hasMany(Pajak::class, 'skpd_id');
        if ($bulan_tahun_id) {
            $query->where('bulan_tahun_id', $bulan_tahun_id);
        }
        return $query->exists();
    }
}
