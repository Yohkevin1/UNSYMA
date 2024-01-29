<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PenanggungJawab extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pj_games';
    protected $guarded = ['id_pj', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function games()
    {
        return $this->belongsTo(Games::class, 'id_games', 'id_games')->withTrashed();
    }

    public function TA()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_ta', 'id_ta')->withTrashed();
    }
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi')->withTrashed();
    }
}
