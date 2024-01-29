<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class C_Pengurus extends Controller
{
    protected $validCreated, $ResponValid, $validUpdate;

    private function uniqueRule($column)
    {
        return Rule::unique('pengurus', $column)->where(function ($query) {
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
            'jabatan' => 'required',
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
            'jabatan.required' => 'Jabatan wajib dipilih.',
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
            'jabatan' => 'required',
            'no_hp' => ['required', 'regex:/^(?:\+62|0[8-9])[0-9]{8,15}$/', 'max:14'],
            'email' => 'required|email|max:255|',
        ];
    }

    public function index(Request $request)
    {
        $ta = $request->input('TA') ?: TahunAkademik::latest('created_at')->first()->id_ta;
        $Pengurus = Pengurus::where('id_ta', $ta);
        $Pengurus = $Pengurus->get();
        $TA = TahunAkademik::all();
        $data = [
            'Pengurus' => $Pengurus,
            'TA' => $TA,
            'ta' => $ta,
        ];
        if ($request->ajax()) {
            return view('pengurus.partial_table', compact('data'));
        }
        return view('pengurus.indexPengurus', compact('data'));
    }

    public function detail($id)
    {
        $id = decrypt($id);
        $Pengurus = Pengurus::where('id_pengurus', $id)->first();

        return view('pengurus.detailPengurus', compact('Pengurus'));
    }

    public function create()
    {
        $TA = TahunAkademik::all();
        $Prodi = ProgramStudi::all();

        $data = [
            'TA' => $TA,
            'Prodi' => $Prodi,
        ];

        return view('pengurus.createPengurus', compact('data'));
    }

    public function savePengurus(Request $request)
    {
        $validator = Validator::make($request->all(), $this->validCreated, $this->ResponValid);
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Pengurus::insert([
            'nama' => $request->nama,
            'npm' => $request->npm,
            'gender' => $request->gender,
            'id_prodi' => $request->prodi,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'id_ta' => $request->TA,
        ]);

        $request->session()->flash('message', 'Pengurus berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('Pengurus')->withInput();
    }

    public function update($id)
    {
        $id = decrypt($id);
        $Pengurus = Pengurus::where('id_pengurus', $id)->first();
        $TA = TahunAkademik::all();
        $Prodi = ProgramStudi::all();

        $data = [
            'TA' => $TA,
            'Prodi' => $Prodi,
            'Pengurus' => $Pengurus,
        ];
        return view('pengurus.updatePengurus', compact('data'));
    }

    public function updatePengurus(Request $request, $id)
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
            $data = Pengurus::where($field, $request->$field)->whereNot('id_pengurus', $id)->where('id_ta', $request->TA)->first();
            if ($data) {
                $errorMessages[$field] = ucfirst($field) . ' sudah terdaftar';
            }
        }

        if (!empty($errorMessages)) {
            $request->session()->flash('message', implode(', ', $errorMessages));
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withInput();
        }

        Pengurus::where('id_pengurus', $id)->update([
            'nama' => $request->nama,
            'npm' => $request->npm,
            'gender' => $request->gender,
            'id_prodi' => $request->prodi,
            'jabatan' => $request->jabatan,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'id_ta' => $request->TA,
        ]);
        $request->session()->flash('message', 'Data Pengurus berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('Pengurus')->withInput();
    }

    public function delete($id, Request $request)
    {
        $id = decrypt($id);

        Pengurus::where('id_pengurus', $id)->delete();

        $request->session()->flash('message', 'Data Pengurus berhasil didelete');
        $request->session()->flash('alert-type', 'success');
        return redirect()->back()->withInput();
    }
}
