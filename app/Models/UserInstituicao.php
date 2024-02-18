<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserInstituicao extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_instituicoes';

    protected $fillable = ['user_id', 'instituicao_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function instituicao()
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'instituicao_id');
    }
}
