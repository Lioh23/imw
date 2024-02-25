<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControleImportacaoCsv extends Model
{
    use HasFactory;

    protected $table = 'controle_importacoes_csv';

    protected $fillable = ['alias', 'file', 'static_method', 'target_table', 'executed'];
}
