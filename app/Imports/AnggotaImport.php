<?php

namespace App\Imports;

use App\Models\Anggota;
use App\Models\Games;
use App\Models\ProgramStudi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Hash;

class AnggotaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected $id_ta;
    public function __construct($ta)
    {
        $this->id_ta = $ta;
    }

    public function model(array $row)
    {
        $programStudi = ProgramStudi::where('nama_prodi', $row['prodi'])->first();

        $id_prodi = optional($programStudi)->id_prodi ?? $row['prodi'];

        $anggota = new Anggota([
            'nama'      => $row['nama'],
            'npm'       => $row['npm'],
            'gender'    => $row['gender'],
            'id_prodi'  => $id_prodi,
            'no_hp'     => $row['no_hp'],
            'email'     => $row['email'],
            'id_games'  => Games::where('nama_games', $row['games'])->first()->id_games,
            'id_ta'     => $this->id_ta,
        ]);

        return $anggota;
    }

    public function rules(): array
    {
        return [
            'nama'  => 'required',
            'npm'   => 'required',
            'prodi' => 'required',
            'email' => 'required|email',
            'games' => 'required',
        ];
    }
}
