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

    public function regiao()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, UserInstituicao::class, 'user_id', 'instituicao_id', 'id', 'id')
            ->where('instituicoes_instituicoes.tipo_instituicao_id', InstituicoesTipoInstituicao::REGIAO);
    }

    public function distrito()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, UserInstituicao::class, 'user_id', 'instituicao_id', 'id', 'id')
            ->where('instituicoes_instituicoes.tipo_instituicao_id', InstituicoesTipoInstituicao::DISTRITO);
    }

    public function igrejaLocal()
    {
        return $this->belongsToMany(InstituicoesInstituicao::class, UserInstituicao::class, 'user_id', 'instituicao_id', 'id', 'id')
            ->where('instituicoes_instituicoes.tipo_instituicao_id', InstituicoesTipoInstituicao::IGREJA_GERAL);
    }
}
