<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaMembro extends Model
{
    use HasFactory, SoftDeletes, HasUuids, Compoships;

    // status
    const STATUS_ATIVO = 'A';
    const STATUS_INATIVO = 'I';

    // vinculo
    const VINCULO_VISITANTE = 'V';
    const VINCULO_CONGREGADO = 'C';
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
        'congregacao_id',
        'has_errors',
    ];

    protected $casts = [
        'data_nascimento' => 'date'
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

    public function congregacao()
    {
        return $this->belongsTo(CongregacoesCongregacao::class, 'congregacao_id');
    }

    public function rolPermanente()
    {
        return $this->hasMany(MembresiaRolPermanente::class, 'membro_id');
    }
    
    public function rolAtual()
    {
        return $this->hasOne(MembresiaRolPermanente::class, 'membro_id', 'id')->withTrashed()->where('lastrec', 1);
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'A':
                return 'ATIVO';
            
            case 'I':
                return 'INATIVO';
        }
    }

    public function getVinculoTextAttribute()
    {
        switch ($this->vinculo) {
            case 'M':
                return 'MEMBRO';
            case 'C':
                return 'CONGREGADO';
            case 'V':            
                return 'VISITANTE';
        }
    }
}
