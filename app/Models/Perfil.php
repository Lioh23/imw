<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perfil extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nome'];

    public function regras()
    {
        return $this->belongsToMany(Regra::class, 'perfil_regra');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'perfil_user');
    }
}
