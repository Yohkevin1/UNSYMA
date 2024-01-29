<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class TahunAkademik extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'tahun_akademik';
    protected $guarded = ['id_ta', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function getTA()
    {
        return DB::table('tahun_akademik as ta')
            ->select('ta.id_ta', 'ta.nama_ta', DB::raw('COUNT(a.npm) as jumlah_anggota'))
            ->leftJoin('anggota as a', 'ta.id_ta', '=', 'a.id_ta')
            ->whereNull('ta.deleted_at')
            ->groupBy('ta.id_ta', 'ta.nama_ta')
            ->orderBy('ta.id_ta')
            ->get();
    }
}
