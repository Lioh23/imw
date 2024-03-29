<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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

    public function regioes()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, UserInstituicao::class, 'user_id', 'instituicao_id', 'id', 'id')
            ->where('instituicoes_instituicoes.tipo_instituicao_id', InstituicoesTipoInstituicao::REGIAO);
    }

    public function distritos()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, UserInstituicao::class, 'user_id', 'instituicao_id', 'id', 'id')
            ->where('instituicoes_instituicoes.tipo_instituicao_id', InstituicoesTipoInstituicao::DISTRITO);
    }

    public function igrejasLocais()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, UserInstituicao::class, 'user_id', 'instituicao_id', 'id', 'id')
            ->where('instituicoes_instituicoes.tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_LOCAL);
    }

    public function perfilUser()
    {
        return $this->hasMany(PerfilUser::class, 'user_id');
    }

    public function instituicoes()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class)->withPivot('instituicao_id');
    }

    public function perfis()
    {
        return $this->belongsToMany(Perfil::class, 'perfil_user');
    }

    public function hasPerfilRegra($regraNome)
    {
        return $this->perfis->flatMap->regras->contains('nome', $regraNome);
    }    
}
