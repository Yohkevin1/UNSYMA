<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\DetailPertemuan;
use App\Models\Games;
use App\Models\Pertemuan;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class C_Pertemuan extends Controller
{
    protected $validCreated, $ResponValid, $validUpdate;

    private function uniqueRule($column)
    {
        // dd(request('TA'));
        return Rule::unique('pertemuan', $column)->where('id_ta', request('TA'));
    }

    public function __construct()
    {
        $this->validCreated = [
            'meet' => 'required|string|max:100|' . $this->uniqueRule('meet'),
            'TA' => 'required',
            'games' => 'required',
            'opened' => 'required|date',
            'closed' => 'required|date|after:opened',
        ];

        $this->ResponValid = [
            'meet' => [
                'required' => 'Meet wajib diisi.',
                'string' => 'Format meet tidak valid.',
                'max' => 'Meet maksimal 100 karakter.',
                'unique' => 'Meet sudah ada untuk tahun akademik atau games ini.',
            ],
            'TA.required' => 'Tahun akademik wajib dipilih.',
            'games.required' => 'Games wajib dipilih.',
            'opened' => [
                'required' => 'Opened wajib diisi.',
                'date' => 'Format tanggal dibuka tidak valid.',
            ],
            'closed' => [
                'required' => 'Closed wajib diisi.',
                'date' => 'Format tanggal dibuka tidak valid.',
                'after' => 'Tanggal ditutup harus setelah tanggal dibuka.',
            ]
        ];

        $this->validUpdate = [
            'meet' => 'required|string|max:100|',
            'TA' => 'required',
            'games' => 'required',
            'opened' => 'required|date',
            'closed' => 'required|date|after:opened',
        ];
    }

    public function index(Request $request)
    {
        $ta = $request->input('TA');
        $games = $request->input('Games');
        if (empty($ta)) {
            $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        }
        $Pertemuan = Pertemuan::where('id_ta', $ta);
        if ($games != 0) {
            $Pertemuan = $Pertemuan->where('id_games', $games);
            $games = Games::where('id_games', $games)->first();
        }
        $Pertemuan = $Pertemuan->get();
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $data = [
            'Pertemuan' => $Pertemuan,
            'TA' => $TA,
            'ta' => $ta,
            'games' => $games,
            'Games' => $Games
        ];
        if ($request->ajax()) {
            return view('pertemuan.partial_table', compact('data'));
        }
        return view('pertemuan.indexPertemuan', compact('data'));
    }

    public function create()
    {
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $data = [
            'TA' => $TA,
            'Games' => $Games
        ];
        return view('pertemuan.createPertemuan', compact('data'));
    }

    public function savePertemuan(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validCreated, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
        }
        $anggota = Anggota::where('id_ta', $request->TA)->where('id_games', $request->games)->get();
        if ($anggota->isEmpty()) {
            $response = [
                'message' => 'Tidak bisa buat pertemuan jika anggota kosong',
                'alert-type' => 'error',
            ];
            return redirect()->back()->withInput()->with($response);
        }

        Pertemuan::insert([
            'meet' => $request->meet,
            'id_games' => $request->games,
            'id_ta' => $request->TA,
            'opened' => $request->opened,
            'closed' => $request->closed,
        ]);

        foreach ($anggota as $key => $value) {
            DetailPertemuan::insert([
                'id_pertemuan' => Pertemuan::latest('created_at')->first()->id_pertemuan,
                'id_anggota' => $value->id_anggota,
                'status' => 'Alpha',
            ]);
        }

        $response = [
            'message' => 'Pertemuan berhasil ditambahkan',
            'alert-type' => 'success',
        ];
        return redirect()->route('Pertemuan')->withInput()->with($response);
    }

    public function update($id)
    {
        $id = decrypt($id);
        $Pertemuan = Pertemuan::where('id_pertemuan', $id)->first();
        $Games = Games::all();
        $TA = TahunAkademik::all();

        $data = [
            'TA' => $TA,
            'Games' => $Games,
            'Pertemuan' => $Pertemuan,
        ];
        return view('pertemuan.updatePertemuan', compact('data'));
    }

    public function updatePertemuan(Request $request, $id)
    {
        $id = decrypt($id);
        $validator = Validator::make($request->all(), $this->validUpdate, $this->ResponValid);
        if ($validator->fails()) {
            $response = [
                'message' => $validator->errors()->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->withErrors($validator)->withInput()->with($response);
        }

        $rules = ['meet'];
        foreach ($rules as $field) {
            $data = Pertemuan::where($field, $request->$field)->whereNot('id_pertemuan', $id)->where('id_ta', $request->TA)->where('id_games', $request->games)->first();
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

        Pertemuan::where('id_pertemuan', $id)->update([
            'meet' => $request->meet,
            'id_games' => $request->games,
            'id_ta' => $request->TA,
            'opened' => $request->opened,
            'closed' => $request->closed,
        ]);
        $response = [
            'message' => 'Data pertemuan berhasil diupdate',
            'alert-type' => 'success',
        ];
        return redirect()->route('Pertemuan')->withInput()->with($response);
    }

    public function delete($id)
    {
        $id = decrypt($id);

        Pertemuan::where('id_pertemuan', $id)->delete();

        $response = [
            'message' => 'Data pertemuan berhasil didelete',
            'alert-type' => 'success',
        ];
        return redirect()->back()->withInput()->with($response);
    }
}
