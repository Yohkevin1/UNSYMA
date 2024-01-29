<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DetailPertemuan;
use App\Models\Games;
use App\Models\Pertemuan;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class C_Form extends Controller
{
    protected $validCreated, $ResponValid, $PresensiRule, $ResponValidPresensi, $close, $open;

    private function uniqueRule($column)
    {
        return Rule::unique('anggota', $column)->where(function ($query) {
            return $query->where('id_ta', request('TA'));
        });
    }

    public function __construct()
    {
        $this->validCreated = [
            'nama' => 'required|string|max:100|' . $this->uniqueRule('nama'),
            'npm' => ['required', 'numeric', 'max:9999999999', $this->uniqueRule('npm')],
            'gender' => 'required',
            'prodi' => 'required',
            'games' => 'required',
            'no_hp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/', $this->uniqueRule('no_hp'), 'max:14'],
            'email' => ['required', 'email', $this->uniqueRule('email'), 'max:255'],
        ];

        $this->ResponValid = [
            'nama' => [
                'required' => 'Nama wajib diisi.',
                'string' => 'Format nama tidak valid.',
                'max' => 'Nama maksimal 100 karakter.',
                'unique' => 'Nama sudah terdaftar untuk tahun akademik ini.',
            ],
            'npm' => [
                'required' => 'NPM wajib diisi.',
                'numeric' => 'Format NPM tidak valid.',
                'unique' => 'NPM sudah terdaftar untuk tahun akademik ini.',
                'max' => 'NPM maksimal 10 anggka.',
            ],
            'gender.required' => 'Jenis kelamin wajib dipilih.',
            'prodi.required' => 'Program studi wajib dipilih.',
            'TA.required' => 'Tahun akademik wajib dipilih.',
            'games.required' => 'Games wajib dipilih.',
            'email' => [
                'required' => 'Email wajib diisi.',
                'email' => 'Format email tidak valid.',
                'max' => 'Email maksimal 255 karakter.',
                'unique' => 'Email sudah dimiliki untuk tahun akademik ini.',
            ],
            'no_hp' => [
                'required' => 'Nomor HP wajib diisi.',
                'regex' => 'Format nomor HP tidak valid.',
                'max' => 'Nomor HP maksimal 12 karakter.',
                'unique' => 'Nomor HP sudah dimiliki untuk tahun akademik ini.',
            ],
        ];

        $this->PresensiRule = [
            'npm' => 'required|numeric|max:9999999999',
            'pertemuan' => 'required',
            'foto' => 'required|image|mimes:png,jpg|max:3072',
        ];

        $this->ResponValidPresensi = [
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

        $this->open = Carbon::parse('2023-12-27 13:00:00');
        $this->close = $this->open->copy()->addDays(30);
    }

    public function pendaftaran()
    {
        $now = now();
        if ($now >= $this->close) {
            return view('form.ErrorClose');
        }
        $Games = Games::all();
        $Prodi = ProgramStudi::all();
        $TA = TahunAkademik::latest('created_at')->first();

        $data = [
            'TA' => $TA,
            'Prodi' => $Prodi,
            'Games' => $Games
        ];
        return view('form.pendaftaran', compact('data'));
    }

    public function submitForm(Request $request)
    {
        $now = now();
        if ($now >= $this->close) {
            $response = [
                'message' => 'Pendaftaran sudah ditutup.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($response);
        }
        if ($now <= $this->open) {
            $response = [
                'message' => 'Pendaftaran Belum Dibuka.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->withInput()->with($response);
        }

        $validator = Validator::make($request->all(), $this->validCreated, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
        }

        $GamesKapasitas = Games::where('id_games', $request->games)->value('kapasitas');
        $registeredPlayers = Anggota::where('id_ta', $request->TA)->where('id_games', $request->games)->count();

        if ($registeredPlayers >= $GamesKapasitas) {
            $response = [
                'message' => 'Pendaftaran untuk games ini sudah penuh',
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($response);
        }

        Anggota::insert([
            'nama' => $request->nama,
            'npm' => $request->npm,
            'gender' => $request->gender,
            'id_prodi' => $request->prodi,
            'id_games' => $request->games,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'id_ta' => $request->TA,
        ]);

        $response = [
            'message' => 'Data anda berhasil ditambahkan',
            'alert-type' => 'success',
        ];
        return view('form.group')->with($response);
    }

    public function presensi()
    {
        $Pertemuan = Pertemuan::where('opened', '>', now())->orWhere('closed', '>', now())->get();
        if ($Pertemuan->isNotEmpty()) {
            $ta = TahunAkademik::latest('created_at')->first()->id_ta;
            $Pertemuan = Pertemuan::where('id_ta', $ta)->get();
            return view('form.presensi', compact('Pertemuan'));
        } else {
            return view('form.ErrorClose');
        }
    }

    public function submitPresensi(Request $request)
    {
        $validator = Validator::make($request->all(), $this->PresensiRule, $this->ResponValidPresensi);
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
        if (DetailPertemuan::where('id_pertemuan', $request->pertemuan)->where('id_anggota', $anggota->id_anggota)->where('status', 'Hadir')->first()) {
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

        if (DetailPertemuan::where('id_pertemuan', $request->pertemuan)->where('id_anggota', $anggota->id_anggota)->where('status', 'Alpha')->first()) {
            DetailPertemuan::where('id_pertemuan', $request->pertemuan)->where('id_anggota', $anggota->id_anggota)->update([
                'id_pertemuan' => $request->pertemuan,
                'id_anggota' => $anggota->id_anggota,
                'foto' => $namaFile,
                'status' => 'Hadir',
                'created_at' => now(),
            ]);
        } else {
            DetailPertemuan::insert([
                'id_pertemuan' => $request->pertemuan,
                'id_anggota' => $anggota->id_anggota,
                'foto' => $namaFile,
                'status' => 'Hadir',
                'created_at' => now(),
            ]);
        }

        $response = [
            'message' => 'Data presensi telah ditambahkan',
            'alert-type' => 'success',
        ];
        return redirect()->back()->withInput()->with($response);
    }
}
