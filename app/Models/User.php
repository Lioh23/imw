<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    const GERAL = 'G';
    const LOCAL = 'L';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function perfilUser()
    {
        return $this->hasMany(PerfilUser::class, 'user_id');
    }

    public function perfilUserInstituicao()
    {
        return $this->hasMany(PerfilUser::class, 'user_id')->where('instituicao_id', session()->get('session_perfil')->instituicao_id);
    }

    public function instituicoes()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, 'user_instituicoes', 'user_id', 'instituicao_id', 'users.id', 'instituicoes_instituicoes.id');
    }

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_user');
    }

    /* public function hasPerfilRegra($regraNome)
    {
        return $this->perfis->flatMap->regras->contains('nome', $regraNome);
    } */


    public function hasPerfilRegra($regraNome)
    {
        $sessionId = session()->get('session_perfil')->instituicao_id;

        return $this->perfis()
                    ->where('instituicao_id', $sessionId)
                    ->whereHas('regras', function ($query) use ($regraNome) {
                        $query->where('nome', $regraNome);
                    })
                    ->exists();
    }

}
