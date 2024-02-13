<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VisitantesController extends Controller
{

    public function index()
    {
        return view('visitantes.index');
    }

    public function create()
    {
        return view('visitantes.create');
    }

    public function store(Request $request)
    {
        dd($request->all());
    }

   
}
