<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MembresiaContato extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'membresia_contatos';

    protected $fillable = [
        'telefone_preferencial',
        'telefone_alternativo',
        'telefone_whatsapp',
        'email_preferencial',
        'email_alternativo',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'observacoes',
        'membro_id'
    ];
}
