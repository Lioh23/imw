<?php

namespace App\Services\ServicePerfil;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdatePerfilService
{
    public function execute($request, $id)
    {
        $usuario = User::find(Auth::id()); 

        $usuario->name = $request->name;
        $usuario->email = $request->email;
    
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }
    
        $usuario->save();

    }
}


