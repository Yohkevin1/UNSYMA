<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Games extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'games';
    protected $guarded = ['id_games', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at']; // Aktifkan soft deletes

    public function getGames($ta)
    {
        return DB::table('games as g')
            ->select('g.id_games', 'g.nama_games', DB::raw('COUNT(a.npm) as jumlah_anggota'), 'g.kapasitas')
            ->leftJoin('anggota as a', function ($join) use ($ta) {
                $join->on('g.id_games', '=', 'a.id_games')
                    ->where('a.id_ta', '=', $ta);
            })
            ->whereNull('g.deleted_at')
            ->groupBy('g.id_games', 'g.nama_games', 'g.kapasitas')
            ->orderBy('g.id_games')
            ->get();
    }
}
