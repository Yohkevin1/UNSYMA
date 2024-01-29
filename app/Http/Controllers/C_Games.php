<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\TahunAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class C_Games extends Controller
{
    protected $gamesModel;

    public function __construct()
    {
        $this->gamesModel = new Games();
    }

    public function index()
    {
        $ta = TahunAkademik::latest('created_at')->first()->id_ta;
        $games =  $this->gamesModel->getGames($ta);
        return view('games.indexGames', compact('games'));
    }

    public function create()
    {
        return view('games.createGames');
    }

    public function saveGames(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'games' => 'required|string|max:30|unique:games,nama_games',
                'kapasitas' => 'required'
            ],
            [
                'games.required' => 'Nama Games wajib diisi!',
                'games.max' => 'Nama Games maksimal 30 karakter!',
                'games.unique' => 'Nama Games sudah ada!',
                'kapasitas.required' => 'kapasitas wajib diisi!',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Games::insert([
            'nama_games' => $request->games,
            'nama_games' => $request->kapasitas,
        ]);
        $request->session()->flash('message', 'Games berhasil ditambahkan');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('games')->withInput();
    }

    public function update($id)
    {
        $id = decrypt($id);
        $games = Games::where('id_games', $id)->first();
        return view('games.updateGames', compact('games'));
    }

    public function updateGames(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'games' => 'required|string|max:30',
                'kapasitas' => 'required'
            ],
            [
                'games.required' => 'Nama Games wajib diisi!',
                'games.max' => 'Nama Games maksimal 30 karakter!',
                'kapasitas.required' => 'kapasitas wajib diisi!',
            ]
        );
        if ($validator->fails()) {
            $request->session()->flash('message', $validator->errors()->first());
            $request->session()->flash('alert-type', 'error');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $id = decrypt($id);
        Games::where('id_games', $id)->update([
            'nama_games' => $request->games,
            'kapasitas' => $request->kapasitas,
        ]);
        $request->session()->flash('message', 'Games berhasil diupdate');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('games')->withInput();
    }

    public function delete($id, Request $request)
    {
        $id = decrypt($id);

        Games::where('id_games', $id)->delete();

        $request->session()->flash('message', 'Data Games berhasil didelete');
        $request->session()->flash('alert-type', 'success');
        return redirect()->route('games')->withInput();
    }
}
