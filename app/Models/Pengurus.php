<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengurus extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pengurus';
    protected $guarded = ['id_pengurus', 'created_at', 'updated_at', 'deleted_at'];
    protected $dates = ['deleted_at'];

    public function TA()
    {
        return $this->belongsTo(TahunAkademik::class, 'id_ta', 'id_ta')->withTrashed();
    }
    public function prodi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi')->withTrashed();
    }
}
