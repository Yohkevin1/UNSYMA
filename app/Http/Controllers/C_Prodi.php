<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Prodi extends Controller
{
    protected $ProdiModel;

    public function __construct()
    {
        $this->ProdiModel = new ProgramStudi();
    }

    public function index()
    {
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $prodi = $this->ProdiModel->getProdi($ta);
        return view('prodi.indexProdi', compact('prodi'));
    }

    public function create()
    {
        return view('prodi.createProdi');
    }

    public function saveProdi(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'Prodi' => 'required|string|max:30|unique:prodi,nama_prodi',
            ],
            [
                'Prodi.required' => 'Nama Prodi wajib diisi!',
                'Prodi.max' => 'Nama Prodi maksimal 30 karakter!',
                'Prodi.unique' => 'Nama Prodi sudah ada!',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ProgramStudi::insert([
            'nama_prodi' => $request->Prodi,
        ]);
        $request->session()->flash('message', 'Prodi berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('prodi')->withInput();
    }

    public function update($id)
    {
        $id = decrypt($id);
        $prodi = ProgramStudi::where('id_prodi', $id)->first();
        return view('prodi.updateProdi', compact('prodi'));
    }

    public function updateProdi(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'Prodi' => 'required|string|max:30',
            ],
            [
                'Prodi.required' => 'Nama Prodi wajib diisi!',
                'Prodi.max' => 'Nama Prodi maksimal 30 karakter!',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = decrypt($id);
        ProgramStudi::where('id_prodi', $id)->update([
            'nama_prodi' => $request->Prodi,
        ]);
        $request->session()->flash('message', 'Prodi berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('prodi')->withInput();
    }

    public function delete($id, Request $request)
    {
        $id = decrypt($id);

        ProgramStudi::where('id_Prodi', $id)->delete();

        $request->session()->flash('message', 'Data Prodi berhasil didelete');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('prodi')->withInput();
    }
}
