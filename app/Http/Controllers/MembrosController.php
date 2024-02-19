<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembrosController extends Controller
{
   
   
    public function index()
    {
        return view('membros.index');
    }

  
    public function editar($id)
    {
        return view('membros.editar');
    }

   
}
