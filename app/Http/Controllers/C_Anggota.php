<?php

namespace App\Http\Controllers;

use App\Imports\AnggotaImport;
use App\Models\Anggota;
use App\Models\Games;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class C_Anggota extends Controller
{
    protected $validCreated, $ResponValid, $validUpdate;

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
            'TA' => 'required',
            'games' => 'required',
            'no_hp' => ['regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/', $this->uniqueRule('no_hp'), 'max:14'],
            'email' => ['email', $this->uniqueRule('email'), 'max:255'],
        ];

        $this->ResponValid = [
            'nama' => [
                'required' => 'Nama wajib diisi.',
                'string' => 'Format nama tidak valid.',
                'max' => 'Nama maksimal 100 karakter.',
                'unique' => 'Nama sudah ada untuk tahun akademik ini.',
            ],
            'npm' => [
                'required' => 'NPM wajib diisi.',
                'numeric' => 'Format NPM tidak valid.',
                'unique' => 'NPM sudah ada untuk tahun akademik ini.',
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

        $this->validUpdate = [
            'nama' => 'required|string|max:100|',
            'npm' => 'required|numeric|max:9999999999|',
            'gender' => 'required',
            'prodi' => 'required',
            'TA' => 'required',
            'games' => 'required',
            'no_hp' => ['regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/', 'max:14'],
            'email' => 'email|max:255|',
        ];
    }

    public function index(Request $request)
    {
        $ta = $request->input('TA');
        $games = $request->input('Games');
        if (empty($ta)) {
            $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        }
        $Anggota = Anggota::where('id_ta', $ta);
        if ($games != 0) {
            $Anggota = $Anggota->where('id_games', $games);
            $games = Games::where('id_games', $games)->first();
        }
        $Anggota = $Anggota->get();
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $data = [
            'Anggota' => $Anggota,
            'TA' => $TA,
            'ta' => $ta,
            'games' => $games,
            'Games' => $Games
        ];
        if ($request->ajax()) {
            return view('anggota.partial_table', compact('data'));
        }
        return view('anggota.indexAnggota', compact('data'));
    }

    public function detail($id)
    {
        $id = decrypt($id);
        $Anggota = Anggota::where('id_anggota', $id)->first();

        return view('anggota.detailAnggota', compact('Anggota'));
    }

    public function create()
    {
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $Prodi = ProgramStudi::all();

        $data = [
            'TA' => $TA,
            'Prodi' => $Prodi,
            'Games' => $Games
        ];

        return view('anggota.createAnggota', compact('data'));
    }

    public function saveAnggota(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validCreated, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
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
            'message' => 'Data anggota berhasil ditambahkan',
            'alert-type' => 'success',
        ];
        return redirect()->route('Anggota')->withInput()->with($response);
    }

    public function update($id)
    {
        $id = decrypt($id);
        $Anggota = Anggota::where('id_anggota', $id)->first();
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $Prodi = ProgramStudi::all();

        $data = [
            'TA' => $TA,
            'Prodi' => $Prodi,
            'Games' => $Games,
            'Anggota' => $Anggota,
        ];
        return view('anggota.updateAnggota', compact('data'));
    }

    public function updateAnggota(Request $request, $id)
    {
        $id = decrypt($id);
        $validator = Validator::make($request->all(), $this->validUpdate, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rules = ['npm', 'nama', 'no_hp', 'email'];
        foreach ($rules as $field) {
            $data = Anggota::where($field, $request->$field)->whereNot('id_anggota', $id)->where('id_ta', $request->TA)->first();
            if ($data) {
                $errorMessages[$field] = ucfirst($field) . ' sudah terdaftar';
            }
        }

        if (!empty($errorMessages)) {
            $response = [
                'message' => implode(', ', $errorMessages),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withInput()->with($response);
        }

        Anggota::where('id_anggota', $id)->update([
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
            'message' => 'Data anggota berhasil diupdate',
            'alert-type' => 'success',
        ];
        return redirect()->route('Anggota')->withInput()->with($response);
    }

    public function delete($id)
    {
        $id = decrypt($id);

        Anggota::where('id_anggota', $id)->delete();

        $response = [
            'message' => 'Data Anggota berhasil didelete',
            'alert-type' => 'success',
        ];
        return redirect()->back()->withInput()->with($response);
    }

    public function import(Request $request)
    {
        if (request()->file('file') == null) {
            $response = [
                'message' => 'File kosong.',
                'alert-type' => 'error',
            ];
            return redirect()->back()->withInput()->with($response);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'file' => 'required|file|mimes:xls,xlsx|max:2048',
            ],
            [
                'file.required' => 'File wajib diunggah.',
                'file.mimes' => 'File harus berupa file Excel (xls atau xlsx).',
                'file.max' => 'Ukuran file tidak boleh melebihi 2 MB.',
            ]
        );

        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
        }

        Excel::import(new AnggotaImport($request->TA), request()->file('file'));

        return back();
    }
}
