<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacoesTranferenciaController extends Controller
{
    public function index()
    {
        return view('notificacoes-transferencia.index');
    }
}