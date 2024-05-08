<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    use HasFactory, SoftDeletes;

    const NIVEL_IGREJA = 'I';
    const NIVEL_DISTRITO = 'D';
    const NIVEL_REGIAO = 'R';


    protected $fillable = ['nome', 'nivel'];

    public function regras()
    {
        return $this->belongsToMany(Regra::class, 'perfil_regra');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'perfil_user');
    }
}
