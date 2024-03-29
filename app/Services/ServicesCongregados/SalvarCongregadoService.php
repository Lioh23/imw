<?php

namespace App\Services\ServicesCongregados;

use App\Exceptions\MembroNotFoundException;
use App\Models\MembresiaContato;
use App\Models\MembresiaCurso;
use App\Models\MembresiaFamiliar;
use App\Models\MembresiaFormacao;
use App\Models\MembresiaFormacaoEclesiastica;
use App\Models\MembresiaFuncaoEclesiastica;
use App\Models\MembresiaFuncaoMinisterial;
use App\Models\MembresiaMembro;
use App\Models\MembresiaSetor;
use App\Models\MembresiaTipoAtuacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class SalvarCongregadoService
{

    public function execute(array $data)
    {
        $dataMembro = $this->prepareMembroData($data);
        $dataContato = $this->prepareContatoData($data);
        $dataFamiliar = $this->prepareFamiliarData($data);
        $dataFormacoes = $this->prepareFormacoesData($data);
        $dataMinisteriais = $this->prepareMinisteriaisData($data);

        $membroID = $this->handleCreateMembro($dataMembro);
        $this->handleCreateContato($dataContato, $membroID);
        $this->handleCreateFamiliar($dataFamiliar, $membroID);
        $this->handleCreateFormacoes($dataFormacoes, $membroID);
        $this->handleCreateMinisteriais($dataMinisteriais, $membroID);

        if (isset($data['foto'])) {
            $this->handlePhotoUpload($data['foto'], $membroID);
        }
        
        return $membroID;
    }

    private function handlePhotoUpload($photo, $membroId)
    {
        $filePath = $photo->store('fotos', 'minio');
        Storage::disk('minio')->setVisibility($filePath, 'public');

        $membro = MembresiaMembro::find($membroId);
        if ($membro) {
            $membro->foto = Storage::disk('minio')->url($filePath);
            $membro->save();
        }
    }

    private function prepareMembroData(array $data): array
    {
        return [
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
            'status' => 'A',
            'regiao_id'       => Auth::user()->regioes->first()->id,
            'distrito_id'     => Auth::user()->distritos->first()->id,
            'igreja_id'       => Auth::user()->igrejasLocais->first()->id,
        ];
    }

    private function prepareContatoData(array $data): array
    {
        return [
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
    }

    private function prepareFamiliarData(array $data): array
    {
        return [
            'mae_nome' => $data['mae_nome'],
            'pai_nome' => $data['pai_nome'],
            'conjuge_nome' => $data['conjuge_nome'],
            'data_casamento' => $data['data_casamento'],
            'filhos' => $data['filhos'],
            'historico_familiar' => $data['historico_familiar'],
        ];
    }

    private function prepareFormacoesData(array $data): array
    {
        $dataFormacoes = [];
        if (!empty($data['curso-nome'])) {
            foreach ($data['curso-nome'] as $index => $nome) {
                $dataFormacoes[] = [
                    'curso_id' => $nome,
                    'inicio' => $data['curso-data-inicio'][$index] ?? null,
                    'termino' => $data['curso-data-conclusao'][$index] ?? null,
                    'observacao' => $data['curso-observacao'][$index] ?? '',
                ];
            }
        }
        return $dataFormacoes;
    }

    private function prepareMinisteriaisData(array $data): array
    {
        $dataMinisteriais = [];
        if (!empty($data['ministerial-departamento'])) {
            foreach ($data['ministerial-departamento'] as $index => $departamento) {
                $dataMinisteriais[] = [
                    'setor_id' => $departamento,
                    'tipoatuacao_id' => $data['ministerial-funcao'][$index] ?? null,
                    'data_entrada' => $data['ministerial-nomeacao'][$index] ?? null,
                    'data_saida' => $data['ministerial-exoneracao'][$index] ?? null,
                    'observacoes' => $data['ministerial-observacao'][$index] ?? '',
                ];
            }
        }
        return $dataMinisteriais;
    }

    private function handleCreateMembro($data)
    {
        $membresia = MembresiaMembro::Create($data);
        return $membresia->id;
    }

    private function handleCreateContato($data, $membroId): void
    {
        MembresiaContato::updateOrCreate(['membro_id' => $membroId], $data);
    }

    private function handleCreateFamiliar($data, $membroId): void
    {
        MembresiaFamiliar::updateOrCreate(['membro_id' => $membroId], $data);
    }

    private function handleCreateFormacoes(array $formacoes, $membroId): void
    {

        $idsExistentes = MembresiaFormacaoEclesiastica::where('membro_id', $membroId)
            ->pluck('curso_id')->toArray();

        $idsAtualizados = [];
        foreach ($formacoes as $formacao) {
            if (!empty($formacao['curso_id'])) {
                $formacao['membro_id'] = $membroId;
                MembresiaFormacaoEclesiastica::updateOrCreate(
                    ['membro_id' => $membroId, 'curso_id' => $formacao['curso_id']],
                    $formacao
                );
                $idsAtualizados[] = $formacao['curso_id'];
            }
        }

        $idsParaRemover = array_diff($idsExistentes, $idsAtualizados);
        if (!empty($idsParaRemover)) {
            MembresiaFormacaoEclesiastica::where('membro_id', $membroId)
                ->whereIn('curso_id', $idsParaRemover)
                ->delete();
        }
    }

    private function handleCreateMinisteriais(array $ministeriais, $membroId): void
    {

        $updatedMinisterialIds = [];

        foreach ($ministeriais as $ministerial) {
            if (!empty($ministerial['setor_id']) && !empty($ministerial['tipoatuacao_id'])) {
                $ministerial['membro_id'] = $membroId;
                $ministerialModel = MembresiaFuncaoMinisterial::updateOrCreate(
                    [
                        'membro_id' => $membroId,
                        'setor_id' => $ministerial['setor_id'],
                        'tipoatuacao_id' => $ministerial['tipoatuacao_id'],
                    ],
                    $ministerial
                );
    
                $updatedMinisterialIds[] = $ministerialModel->id;
            }
        }

        MembresiaFuncaoMinisterial::where('membro_id', $membroId)
            ->whereNotIn('id', $updatedMinisterialIds)
            ->delete();
    }

}
