<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUser extends Model
{
    use HasFactory;

    protected $table = 'perfil_user'; 

    protected $fillable = [
        'user_id',
        'perfil_id',
        'instituicao_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function perfil()
    {
        return $this->belongsTo(Perfil::class);
    }

    public function instituicao()
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'instituicao_id');
    }
}
