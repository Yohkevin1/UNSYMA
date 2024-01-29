<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class ProgramStudi extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'prodi';
    protected $guarded = ['id_prodi', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function getProdi($ta)
    {
        return DB::table('prodi as ps')
            ->select('ps.id_prodi', 'ps.nama_prodi', DB::raw('COUNT(a.npm) as jumlah_anggota'))
            ->leftJoin('anggota as a', function ($join) use ($ta) {
                $join->on('ps.id_prodi', '=', 'a.id_prodi')
                    ->where('a.id_ta', '=', $ta);
            })
            ->whereNull('ps.deleted_at')
            ->groupBy('ps.id_prodi', 'ps.nama_prodi')
            ->orderBy('ps.id_prodi')
            ->get();
    }
}
