<?php

namespace App\Services\ServicePerfil;

use App\Models\InstituicoesInstituicao;
use App\Models\MembresiaSetor;
use App\Models\PessoasPessoa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ListPerfilService
{
    public function execute()
    {
        $usuario = Auth::user();
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar essa página.');
        }
        return $usuario;
    }

    public function carteiraDigital()
    {
        $usuario = Auth::user();
        if (!$usuario) {
            return redirect()->route('login')->with('error', 'Você precisa estar logado para acessar essa página.');
        }

        $regiao_id = (int) session()->get('session_perfil')->instituicao_id;
        $instituicao = InstituicoesInstituicao::where('id', $regiao_id)->first();
        $pessoa = PessoasPessoa::where('id', $usuario->pessoa_id)->first();
        $pessoa['nome_regiao'] = $instituicao->nome;
        if ($pessoa->foto) {
            $disk = Storage::disk('s3');
            $pessoa->foto = $disk->temporaryUrl($pessoa->foto, Carbon::now()->addMinutes(15));
        }
        
        if (!$pessoa) {
            return redirect()->route('login')->with('error', 'Você precisa ser membro para acessar a carteira digital.');
        }
        return $pessoa;
    }
}


