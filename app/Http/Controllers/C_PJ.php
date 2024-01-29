<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\PenanggungJawab;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class C_PJ extends Controller
{
    protected $validCreated, $ResponValid, $validUpdate;

    private function uniqueRule($column)
    {
        return Rule::unique('pj_games', $column)->where(function ($query) {
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
            'no_hp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/', $this->uniqueRule('no_hp'), 'max:14'],
            'email' => ['required', 'email', $this->uniqueRule('email'), 'max:255'],
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
            'no_hp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/', 'max:14'],
            'email' => 'required|email|max:255|',
        ];
    }

    public function index(Request $request)
    {
        $ta = $request->input('TA');
        $games = $request->input('Games');
        if (empty($ta)) {
            $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        }
        $PJ = PenanggungJawab::where('id_ta', $ta);
        if ($games != 0) {
            $PJ = $PJ->where('id_games', $games);
            $games = Games::where('id_games', $games)->first();
        }
        $PJ = $PJ->get();
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $data = [
            'PJ' => $PJ,
            'TA' => $TA,
            'ta' => $ta,
            'games' => $games,
            'Games' => $Games
        ];
        if ($request->ajax()) {
            return view('pj.partial_table', compact('data'));
        }
        return view('pj.indexPJ', compact('data'));
    }

    public function detail($id)
    {
        $id = decrypt($id);
        $PJ = PenanggungJawab::where('id_pj', $id)->first();

        return view('pj.detailPJ', compact('PJ'));
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

        return view('pj.createPJ', compact('data'));
    }

    public function savePJ(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validCreated, $this->ResponValid);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        PenanggungJawab::insert([
            'nama' => $request->nama,
            'npm' => $request->npm,
            'gender' => $request->gender,
            'id_prodi' => $request->prodi,
            'id_games' => $request->games,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'id_ta' => $request->TA,
        ]);

        $request->session()->flash('message', 'PJ berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('PJ')->withInput();
    }

    public function update($id)
    {
        $id = decrypt($id);
        $PJ = PenanggungJawab::where('id_pj', $id)->first();
        $Games = Games::all();
        $TA = TahunAkademik::all();
        $Prodi = ProgramStudi::all();

        $data = [
            'TA' => $TA,
            'Prodi' => $Prodi,
            'Games' => $Games,
            'PJ' => $PJ,
        ];
        return view('pj.updatePJ', compact('data'));
    }

    public function updatePJ(Request $request, $id)
    {
        $id = decrypt($id);
        $validator = Validator::make($request->all(), $this->validUpdate, $this->ResponValid);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $rules = ['npm', 'nama', 'no_hp', 'email'];
        foreach ($rules as $field) {
            $data = PenanggungJawab::where($field, $request->$field)->whereNot('id_pj', $id)->where('id_ta', $request->TA)->first();
            if ($data) {
                $errorMessages[$field] = ucfirst($field) . ' sudah terdaftar';
            }
        }

        if (!empty($errorMessages)) {
            $request->session()->flash('message', implode(', ', $errorMessages));
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withInput();
        }

        PenanggungJawab::where('id_pj', $id)->update([
            'nama' => $request->nama,
            'npm' => $request->npm,
            'gender' => $request->gender,
            'id_prodi' => $request->prodi,
            'id_games' => $request->games,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'id_ta' => $request->TA,
        ]);
        $request->session()->flash('message', 'Data PJ berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('PJ')->withInput();
    }

    public function delete($id, Request $request)
    {
        $id = decrypt($id);

        PenanggungJawab::where('id_pj', $id)->delete();

        $request->session()->flash('message', 'Data PJ berhasil didelete');
        $request->session()->flash('alert-type', 'success');
        return redirect()->back()->withInput();
    }
}
