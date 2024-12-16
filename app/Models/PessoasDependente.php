<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PessoasDependente extends Model
{
    use HasFactory;

    protected $table = "pessoas_dependentes";

    protected $fillable = [
        'pessoa_id',
        'nome',
        'cpf',
        'data_nascimento',
        'parentesco',
        'sexo',
        'declarar_em_irpf',
    ];

    protected $casts = [
        'data_nascimento' => 'date',
        'declarar_em_irpf' => 'boolean',
    ];

    public function pessoa(): BelongsTo
    {
        return $this->belongsTo(PessoasPessoa::class, 'pessoa_id');
    }
}
