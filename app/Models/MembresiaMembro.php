<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaMembro extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    const VINCULO_VISITANTE = 'V';
    const VINCLULO_CONGREGADO = 'C';
    const VINCULO_MEMBRO = 'M';

    protected $table = 'membresia_membros';

    protected $fillable = [
        'status',
        'nome',
        'sexo',
        'data_nascimento',
        'estado_civil',
        'nacionalidade',
        'naturalidade',
        'uf',
        'historico',
        'cpf',
        'distrito_id',
        'igreja_id',
        'regiao_id',
        'escolaridade_id',
        'profissao',
        'documento',
        'documento_complemento',
        'tipo_documento',
        'foto',
        'funcao_eclesiastica_id',
        'rol_atual',
        'igreja_host',
        'data_conversao',
        'data_batismo',
        'data_batismo_espirito',
        'vinculo',
        'congregacao_host',
        'codigo_host',
        'congregacao_id'
    ];

    public function contato()
    {
        return $this->hasOne(MembresiaContato::class, 'membro_id');
    }

    public function familiar()
    {
        return $this->hasOne(MembresiaFamiliar::class, 'membro_id');
    }
  
    public function funcoesMinisteriais()
    {
        return $this->hasMany(MembresiaFuncaoMinisterial::class, 'membro_id');
    }

    public function formacoesEclesiasticas() {
        return $this->hasMany(MembresiaFormacaoEclesiastica::class, 'membro_id');
    }
}
