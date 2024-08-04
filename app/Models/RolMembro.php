<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolMembro extends Model
{
    use HasFactory;

    protected $table = 'vw_rol_membros';

    protected $casts = [
        'dt_recepcao'   => 'date',
        'dt_exclusao'   => 'date',
        'dt_nascimento' => 'date',
    ];

    public function regiao()
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'regiao_id');
    }

    public function distrito()
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'distrito_id');
    }

    public function igreja()
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'igreja_id');
    }

    public function congregacao()
    {
        return $this->belongsTo(CongregacoesCongregacao::class, 'congregacao_id');
    }

    public function igrejaRolAtual() 
    {
        return $this->belongsTo(InstituicoesInstituicao::class, 'rol_atual_igreja_id');
    }

    public function notificacaoTransferenciaAtiva()
    {
        return $this->belongsTo(NotificacaoTransferencia::class, 'notificacao_transferencia_id');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'A':
                return 'ATIVO';
            
            case 'I':
                return 'INATIVO';
            
            case 'T':
                return 'TRANSFERÊNCIA';
        }
    }
}
