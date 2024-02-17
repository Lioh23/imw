<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitanteRequest;
use Illuminate\Http\Request;

class VisitantesController extends Controller
{

    public function index()
    {
        return view('visitantes.index');
    }

    public function novo()
    {
        return view('visitantes.create');
    }

    public function store(StoreVisitanteRequest $request)
    {
       
    }
}
