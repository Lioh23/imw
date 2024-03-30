<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificacaoTransferencia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'notificacoes_transferencias';

    protected $fillable = [
        'membro_id',
        'regiao_origem_id',
        'distrito_origem_id',
        'igreja_origem_id',
        'regiao_destino_id',
        'distrito_destino_id',
        'igreja_destino_id',
        'user_abertura',
        'dt_abertura',
        'user_finalizacao',
        'dt_aceite',
        'dt_rejeicao',
        'motivo_rejeicao',
    ];

    public function membro()
    {
        return $this->belongsTo(MembresiaMembro::class, 'membro_id', 'id');
    }
}
