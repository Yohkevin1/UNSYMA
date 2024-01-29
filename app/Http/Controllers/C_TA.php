<?php

namespace App\Http\Controllers;

use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_TA extends Controller
{
    protected $TAModel;

    public function __construct()
    {
        $this->TAModel = new TahunAkademik();
    }

    public function index()
    {
        $TA = $this->TAModel->getTA();
        return view('tahunAkademik.indexTA', compact('TA'));
    }

    public function create()
    {
        return view('tahunAkademik.createTA');
    }

    public function saveTA(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'TA' => 'required|string|max:30|unique:tahun_akademik,nama_ta',
            ],
            [
                'TA.required' => 'Nama TA wajib diisi!',
                'TA.max' => 'Nama TA maksimal 30 karakter!',
                'TA.unique' => 'Nama TA sudah ada!',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        TahunAkademik::insert([
            'nama_ta' => $request->TA,
        ]);
        $request->session()->flash('message', 'TA berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('TA')->withInput();
    }

    public function update($id)
    {
        $id = decrypt($id);
        $TA = TahunAkademik::where('id_ta', $id)->first();
        return view('tahunAkademik.updateTA', compact('TA'));
    }

    public function updateTA(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'TA' => 'required|string|max:30',
            ],
            [
                'TA.required' => 'Nama TA wajib diisi!',
                'TA.max' => 'Nama TA maksimal 30 karakter!',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = decrypt($id);
        TahunAkademik::where('id_ta', $id)->update([
            'nama_ta' => $request->TA,
        ]);
        $request->session()->flash('message', 'TA berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('TA')->withInput();
    }


    public function delete($id, Request $request)
    {
        $id = decrypt($id);

        TahunAkademik::where('id_ta', $id)->delete();

        $request->session()->flash('message', 'Data TA berhasil didelete');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('TA')->withInput();
    }
}
