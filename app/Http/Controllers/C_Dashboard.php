<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DetailPertemuan;
use App\Models\Games;
use App\Models\Pertemuan;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;

class C_Dashboard extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function totalAnggota()
    {
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $anggota = Anggota::where('id_ta', $ta)->count();
        return response()->json($anggota);
    }

    public function presentKehadiran()
    {
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $Pertemuan = Pertemuan::where('id_ta', $ta)->get();
        $Kehadiran = 0;
        $Alpha = 0;
        $totalPertemuan = count($Pertemuan);

        foreach ($Pertemuan as $value) {
            $Kehadiran += DetailPertemuan::where('id_pertemuan', $value->id_pertemuan)->where('status', "Hadir")->count();
            $Alpha += DetailPertemuan::where('id_pertemuan', $value->id_pertemuan)->where('status', "Alpha")->count();
        }

        $presentaseKehadiran = number_format(($Kehadiran / $totalPertemuan) * 100, 2);
        $presentaseAlpha = number_format(($Alpha / $totalPertemuan) * 100, 2);
        return response()->json([
            'presentaseKehadiran' => $presentaseKehadiran,
            'presentaseAlpha' => $presentaseAlpha,
        ]);
    }

    public function presentPertemuan()
    {
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $games = Games::all();
        $totalPertemuan = 0;
        foreach ($games as $key => $value) {
            $totalPertemuan += Pertemuan::where('id_ta', $ta)->where('id_games', $value->id_games)->count();
        }

        $totalGames = $games->count();

        $presentasePertemuan = ($totalPertemuan / $totalGames);

        return response()->json($presentasePertemuan);
    }

    public function AnggotaPerTahun()
    {
        $ta = TahunAkademik::all();
        $anggota = [];

        foreach ($ta as $key => $value) {
            $anggota[] = Anggota::where('id_ta', $value->id_ta)->count();
        }

        $data = [
            'ta' => $ta,
            'anggota' => $anggota,
        ];

        return response()->json($data);
    }
}
