<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaFormacaoEclesiastica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_formacoeseclesiasticas';

    protected $fillable = ['inicio', 'termino', 'observacao', 'curso_id', 'membro_id'];

    public function membro()
    {
        return $this->belongsTo(MembresiaMembro::class, 'membro_id', 'id');
    }

    public function curso()
    {
        return $this->belongsTo(MembresiaCurso::class, 'curso_id', 'id');
    }
}
