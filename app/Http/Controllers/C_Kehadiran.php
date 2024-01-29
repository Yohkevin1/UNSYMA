<?php

namespace App\Http\Controllers;

use App\Exports\ExportKehadiran;
use App\Exports\ExportKehadiranFix;
use App\Exports\ExportKehadiranTerbaru;
use App\Models\Anggota;
use App\Models\DetailPertemuan;
use App\Models\Games;
use App\Models\Pertemuan;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class C_Kehadiran extends Controller
{
    protected $validRule, $ResponValid, $validUpdate;

    public function __construct()
    {
        $this->validRule = [
            'npm' => 'required|numeric|max:9999999999',
            'pertemuan' => 'required',
            'foto' => 'required|image|mimes:png,jpg|max:3072',
        ];

        $this->ResponValid = [
            'npm' => [
                'required' => 'NPM wajib diisi.',
                'numeric' => 'Format NPM tidak valid.',
                'max' => 'NPM maksimal 10 anggka.',
            ],
            'pertemuan.required' => 'Pertemuan wajib dipilih.',
            'status.required' => 'Status Kehadiran wajib dipilih.',
            'foto' => [
                'required' => 'Bukti Kehadiran wajib diisi.',
                'image' => 'File yang diizinkan hanya PNG, JPG!',
                'mimes' => 'Format file yang diizinkan hanya PNG, JPG!',
                'max' => 'Ukuran file maksimal 3MB!',
            ],
        ];

        $this->validUpdate = [
            'npm' => 'required|numeric|max:9999999999',
            'pertemuan' => 'required',
            'status' => 'required',
            'foto' => 'image|mimes:png,jpg|max:3072',
        ];
    }

    public function index(Request $request)
    {
        $ta = $request->input('TA') ?: TahunAkademik::latest('created_at')->first()->id_ta;
        $games = $request->input('Games');
        $pertemuan = $request->input('Pertemuan');

        $Pertemuan = Pertemuan::where('id_ta', $ta);
        if ($games != 0) {
            $Pertemuan = $Pertemuan->where('id_games', $games);
        }
        $Pertemuan = $Pertemuan->get();

        $pertemuanFound = false;
        foreach ($Pertemuan as $key => $value) {
            if ($value->id_pertemuan == $pertemuan) {
                $pertemuanFound = true;
                break;
            }
        }

        if (!$pertemuanFound) {
            $pertemuan = 0;
        }

        $Kehadiran = [];
        foreach ($Pertemuan as $key => $value) {
            $Kehadiran = DetailPertemuan::leftJoin('pertemuan', 'detail_pertemuan.id_pertemuan', '=', 'pertemuan.id_pertemuan')
                ->where('id_ta', $value->id_ta);

            if ($games != 0) {
                $Kehadiran = $Kehadiran->where('id_games', $games);
            }

            if ($pertemuan != 0) {
                $Kehadiran = $Kehadiran->where('detail_pertemuan.id_pertemuan', $pertemuan);
            }

            $Kehadiran = $Kehadiran->get();
        }

        // dd($Kehadiran);
        $data = [
            'Kehadiran' => $Kehadiran,
            'Pertemuan' => $Pertemuan,
            'pertemuan' => $pertemuan,
            'TA' => TahunAkademik::all(),
            'ta' => $ta,
            'games' => $games ?: 0,
            'Games' => Games::all(),
        ];

        if ($request->ajax()) {
            return view('kehadiran.partial_table', compact('data'));
        }
        return view('kehadiran.indexKehadiran', compact('data'));
    }

    public function create()
    {
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $Pertemuan = Pertemuan::where('id_ta', $ta)->get();
        return view('kehadiran.createKehadiran', compact('Pertemuan'));
    }

    public function saveKehadiran(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validRule, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
        }
        $ta = TahunAkademik::latest('created_at')->value('id_ta');
        $anggota = Anggota::where('npm', $request->npm)->where('id_ta', $ta)->first();
        if (!$anggota) {
            return redirect()->back()->withInput()->with([
                'message' => 'NPM tidak ditemukan',
                'alert-type' => 'error',
            ]);
        }
        if (DetailPertemuan::where('id_pertemuan', $request->pertemuan)->where('id_anggota', $anggota->id_anggota)->first()) {
            return redirect()->back()->withInput()->with([
                'message' => 'NPM ini sudah melakukan presensi',
                'alert-type' => 'error',
            ]);
        }
        $pertemuan = Pertemuan::where('id_pertemuan', $request->pertemuan)->first();
        if (!$pertemuan) {
            return redirect()->back()->withInput()->with([
                'message' => 'Pertemuan tidak ditemukan',
                'alert-type' => 'error',
            ]);
        }
        if ($anggota->id_games != $pertemuan->id_games) {
            return redirect()->back()->withInput()->with([
                'message' => 'NPM Anda tidak dapat digunakan untuk presensi pertemuan ini',
                'alert-type' => 'error',
            ]);
        }
        if ($pertemuan->closed < now()) {
            return redirect()->back()->withInput()->with([
                'message' => 'Presensi untuk pertemuan ini sudah ditutup',
                'alert-type' => 'error',
            ]);
        }
        if ($pertemuan->opened > now()) {
            return redirect()->back()->withInput()->with([
                'message' => 'Presensi untuk pertemuan ini belum dibuka',
                'alert-type' => 'error',
            ]);
        }

        $foto = $request->file('foto');
        if ($foto && $foto->isValid()) {
            $namaFile = $foto->hashName();
            $foto->move('img/buktiPresensi/', $namaFile);
        }

        DetailPertemuan::insert([
            'id_pertemuan' => $request->pertemuan,
            'id_anggota' => $anggota->id_anggota,
            'foto' => $namaFile,
            'status' => 'Hadir',
        ]);

        $response = [
            'message' => 'Data presensi telah ditambahkan',
            'alert-type' => 'success',
        ];
        return redirect()->route('Kehadiran')->withInput()->with($response);
    }

    public function update($pertemuan, $anggota)
    {
        $idPertemuan = decrypt($pertemuan);
        $idAnggota = decrypt($anggota);
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $Kehadiran = DetailPertemuan::where('id_pertemuan', $idPertemuan)->where('id_anggota', $idAnggota)->first();
        $Pertemuan = Pertemuan::where('id_ta', $ta)->get();

        $data = [
            'Kehadiran' => $Kehadiran,
            'Pertemuan' => $Pertemuan,
        ];
        return view('kehadiran.updateKehadiran', compact('data'));
    }

    public function updateKehadiran(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validUpdate, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
        }
        $ta = TahunAkademik::latest('created_at')->value('id_ta');
        $anggota = Anggota::where('npm', $request->npm)->where('id_ta', $ta)->first();
        if (!$anggota) {
            return redirect()->back()->withInput()->with([
                'message' => 'NPM tidak ditemukan',
                'alert-type' => 'error',
            ]);
        }
        $pertemuan = Pertemuan::where('id_pertemuan', $request->pertemuan)->first();
        if (!$pertemuan) {
            return redirect()->back()->withInput()->with([
                'message' => 'Pertemuan tidak ditemukan',
                'alert-type' => 'error',
            ]);
        }
        if ($anggota->id_games != $pertemuan->id_games) {
            return redirect()->back()->withInput()->with([
                'message' => 'NPM Anda tidak dapat digunakan untuk presensi pertemuan ini',
                'alert-type' => 'error',
            ]);
        }
        if ($pertemuan->closed < now()) {
            return redirect()->back()->withInput()->with([
                'message' => 'Presensi untuk pertemuan ini sudah ditutup',
                'alert-type' => 'error',
            ]);
        }
        if ($pertemuan->opened > now()) {
            return redirect()->back()->withInput()->with([
                'message' => 'Presensi untuk pertemuan ini belum dibuka',
                'alert-type' => 'error',
            ]);
        }

        $foto = $request->file('foto');
        if ($request->status == 'Hadir') {
            if (!$foto || !$foto->isValid()) {
                return redirect()->back()->withInput()->with([
                    'message' => 'Jika hadir, sertakan juga fotonya.',
                    'alert-type' => 'error',
                ]);
            }
        }

        $namaFileLama = $request->input('fotoLama');
        if ($foto && $foto->isValid()) {
            $namaFile = $foto->hashName();
            $foto->move('img/buktiPresensi', $namaFile);
            if ($namaFileLama != "") {
                unlink('img/buktiPresensi' . $namaFileLama);
            }
        } else {
            $namaFile = $namaFileLama;
        }

        DetailPertemuan::where('id_pertemuan', $request->pertemuan_lama)->where('id_anggota', $request->id_lama)->update([
            'id_pertemuan' => $request->pertemuan,
            'id_anggota' => $anggota->id_anggota,
            'foto' => $namaFile,
            'status' => $request->status,
        ]);

        $response = [
            'message' => 'Data presensi telah ditambahkan',
            'alert-type' => 'success',
        ];
        return redirect()->route('Kehadiran')->withInput()->with($response);
    }

    public function delete($pertemuan, $anggota)
    {
        $idPertemuan = decrypt($pertemuan);
        $idAnggota = decrypt($anggota);
        DetailPertemuan::where('id_pertemuan', $idPertemuan)->where('id_anggota', $idAnggota)->delete();

        $response = [
            'message' => 'Data Kehadiran berhasil dihapus',
            'alert-type' => 'success',
        ];
        return redirect()->back()->withInput()->with($response);
    }

    public function verifikasi($pertemuan, $anggota)
    {
        $idPertemuan = decrypt($pertemuan);
        $idAnggota = decrypt($anggota);

        DetailPertemuan::where('id_pertemuan', $idPertemuan)->where('id_anggota', $idAnggota)->update([
            'verifikasi' => now(),
        ]);

        $response = [
            'message' => 'Data Kehadiran berhasil diverifikasi',
            'alert-type' => 'success',
        ];
        return redirect()->back()->withInput()->with($response);
    }

    public function eksportKehadiran($ta, $pertemuan, $games)
    {
        $eksport = new ExportKehadiranFix($ta, $pertemuan, $games);

        $namaPertemuan = Pertemuan::where('id_pertemuan', $pertemuan)->value('meet');
        $namaGames = Games::where('id_games', $games)->value('nama_games');

        if (!$namaPertemuan && !$namaGames) {
            $namaFile = 'Laporan Presensi Unisec';
        } elseif (!$namaPertemuan) {
            $namaFile = 'Laporan Presensi ' . $namaGames;
        } elseif (!$namaGames) {
            $namaFile = 'Laporan Presensi ' . $namaPertemuan;
        } else {
            $namaFile = 'Laporan Presensi ' . $namaPertemuan;
        }

        return Excel::download($eksport, $namaFile . '.xlsx');
    }
}
