<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaRolPermanente extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ADESAO = 'A';
    const STATUS_DESISTENCIA = 'D';
    const STATUS_EXCLUSAO = 'E';

    protected $table = 'membresia_rolpermanente';

    protected $fillable = [
        'status',
        'numero_rol',
        'codigo_host',
        'dt_recepcao',
        'dt_exclusao',
        'clerigo_id',
        'distrito_id',
        'igreja_id',
        'membro_id',
        'modo_exclusao_id',
        'modo_recepcao_id',
        'regiao_id',
        'congregacao_id'
    ];

    
    public function igreja()
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'igreja_id');
    }

    public function modoExclusao()
    {
        return $this->belongsTo(MembresiaSituacao::class, 'modo_exclusao_id');
    }

    public function modoRecepcao()
    {
        return $this->belongsTo(MembresiaSituacao::class, 'modo_recepcao_id');
    }

    public function clerigo() {
        return $this->belongsTo(PessoasPessoa::class, 'clerigo_id');
    }

    public function congregacao() {
        return $this->belongsTo(CongregacoesCongregacao::class, 'congregacao_id');
    }
    
}
