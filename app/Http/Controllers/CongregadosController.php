<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CongregadosController extends Controller
{
    public function index() {
        return view('congregados.index');
    }

    public function novo() {
        /* Falta a tela */
    }
}
