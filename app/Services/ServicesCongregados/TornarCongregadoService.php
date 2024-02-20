<?php

namespace App\Services\ServicesCongregados;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaContato;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFamiliar;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;

class TornarCongregadoService
{

    public function execute(array $data): void
    {
        $dataMembro = [
            'membro_id' => $data['membro_id'],
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => $data['data_nascimento'],
            'estado_civil'  => $data['estado_civil'],
            'nacionalidade'  => $data['nacionalidade'],
            'naturalidade'  => $data['naturalidade'],
            'uf'  => $data['uf'],
            'escolaridade_id'  => $data['escolaridade_id'],
            'profissao'  => $data['profissao'],
            'funcao_eclesiastica_id'  => $data['funcao_eclesiastica_id'],
            'cpf'  => preg_replace('/[^0-9]/', '', $data['cpf']),
            'tipo_documento'  => $data['tipo_documento'],
            'documento'  => $data['documento'],
            'documento_complemento'  => $data['documento_complemento'],
            'data_conversao'  => $data['data_conversao'],
            'data_batismo'  => $data['data_batismo'],
            'data_batismo_espirito'  => $data['data_batismo_espirito'],
            'vinculo'         => MembresiaMembro::VINCULO_CONGREGADO,

        ];

        $dataContato = [
            'membro_id' => $data['membro_id'],
            'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
            'telefone_alternativo'  => preg_replace('/[^0-9]/', '', $data['telefone_alternativo']),
            'telefone_whatsapp'     => preg_replace('/[^0-9]/', '', $data['telefone_whatsapp']),
            'email_preferencial'     => $data['email_preferencial'],
            'email_alternativo'     => $data['email_alternativo'],
            'cep' => preg_replace('/[^0-9]/', '', $data['cep']),
            'endereco' => $data['endereco'],
            'numero' => $data['numero'],
            'complemento' => $data['complemento'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'estado' => $data['estado'],
            'observacoes' => $data['observacoes'],
        ];

        $dataFamiliar = [
            'mae_nome' => $data['mae_nome'], 
            'pai_nome' => $data['pai_nome'], 
            'conjuge_nome' => $data['conjuge_nome'],
            'data_casamento' => $data['data_casamento'],
            'filhos' => $data['filhos'],
            'historico_familiar' => $data['historico_familiar'],
            'membro_id' => $data['membro_id'],
        ];

        $this->handleUpdateMembro($dataMembro);
        $this->handleUpdateContato($dataContato);
        $this->handleUpdateFamiliar($dataFamiliar);
    }

    private function handleUpdateMembro($data): void
    {
        $membroId = $data['membro_id'];
        $membro = MembresiaMembro::find($membroId);
         if ($membro) {
            $membro->update($data);
         } else {
             throw new \Exception("Registro não encontrado."); 
        }
    }

    private function handleUpdateContato($data): void
    {
        $membroId = $data['membro_id'];
        MembresiaContato::updateOrCreate(
            ['membro_id' => $membroId], 
            $data 
        );      
    }

    private function handleUpdateFamiliar($data): void
    {
        $membroId = $data['membro_id'];
        MembresiaFamiliar::updateOrCreate(
            ['membro_id' => $membroId], 
            $data 
        );    
    }

    public function findOne($id)
    {
        //With trazer relacionamentos definidos do model MembresiaMembro de forma prévia
        $pessoa = MembresiaMembro::with(['contato', 'funcoesMinisteriais', 'familiar', 'formacoesEclesiasticas'])
            ->where('id', $id)
            ->whereIn('vinculo', [MembresiaMembro::VINCULO_VISITANTE, MembresiaMembro::VINCULO_CONGREGADO])
            ->firstOr(function () { throw new MembroNotFoundException('Visitante não encontrado', 404); });

        //Somente buscar informações do campo select
        $ministerios = MembresiaSetor::orderBy('descricao', 'asc')->get();
        $funcoes = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();
        $cursos = MembresiaCurso::orderBy('nome', 'asc')->get();
        $formacoes = MembresiaFormacao::orderBy('descricao', 'asc')->get();
        $funcoesEclesiasticas = MembresiaFuncaoEclesiastica::orderBy('descricao', 'asc')->get();

        return [
            'pessoa'               => $pessoa,
            'ministerios'          => $ministerios,
            'funcoes'              => $funcoes,
            'cursos'               => $cursos,
            'formacoes'            => $formacoes,
            'funcoesEclesiasticas' => $funcoesEclesiasticas,
        ];
    }
}
