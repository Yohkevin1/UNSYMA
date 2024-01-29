<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DetailPertemuan extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'detail_pertemuan';
    protected $guarded = ['created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function games()
    {
        return $this->belongsTo(Games::class, 'id_games', 'id_games')->withTrashed();
    }
    public function TA()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_ta', 'id_ta')->withTrashed();
    }
    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'id_anggota', 'id_anggota')->withTrashed();
    }
    public function pertemuan()
    {
        return $this->belongsTo(Pertemuan::class, 'id_pertemuan', 'id_pertemuan')->withTrashed();
    }

    public function getKehadiran($ta, $games, $pertemuan)
    {
        return DB::table('anggota')
            ->select('anggota.nama', 'pertemuan.meet', 'dp.status', 'dp.created_at')
            ->leftJoin('detail_pertemuan dp', 'dp.id_anggota', '=', 'anggota.id_anggota')
            ->leftJoin('pertemuan', 'dp.id_pertemuan', '=', 'pertemuan.id_pertemuan')
            ->leftJoin('tahun_akademik as ta', 'pertemuan.id_ta', '=', 'ta.id_ta')
            ->leftJoin('games', 'anggota.id_games', '=', 'games.id_games')
            ->where('ta.id_ta', $ta);
    }
}
