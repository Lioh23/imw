<?php

namespace App\Services\ServicesUsuarios;

use App\Models\Perfil;

class NovoUsuarioService
{

    public function execute()
    {
        // Obtém o perfil_id da sessão
        $perfilID = session('session_perfil')->perfil_id;
        
        // Recupera o nível do perfil baseado no perfil_id
        $perfilUsuario = Perfil::where('id', $perfilID)->first();
        
        // Verifica o nível do perfil
        if ($perfilUsuario) {
            $nivelPerfil = $perfilUsuario->nivel;
            
            // Agora você pode fazer qualquer lógica adicional com base no nível do perfil
            // Exemplo: Recuperar perfis com o nível de igreja
            $perfils = Perfil::where('nivel', $nivelPerfil)->orderBy('nome', 'asc')->get();
            
            return $perfils;
        }

        return null; // Retorna null se não encontrar o perfil
    }
}
