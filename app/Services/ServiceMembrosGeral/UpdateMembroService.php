<?php

namespace App\Services\ServiceMembrosGeral;

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
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UpdateMembroService
{

    public function execute(array $data, $vinculo): void
    {
        $dataMembro = $this->prepareMembroData($data, $vinculo);
        $dataContato = $this->prepareContatoData($data);
        $dataFamiliar = $this->prepareFamiliarData($data);
        $dataFormacoes = $this->prepareFormacoesData($data);
        $dataMinisteriais = $this->prepareMinisteriaisData($data);

        $membroID = $this->handleUpdateMembro($dataMembro);
        $this->handleUpdateContato($dataContato, $membroID);
        $this->handleUpdateFamiliar($dataFamiliar, $membroID);
        $this->handleUpdateFormacoes($dataFormacoes, $membroID);
        $this->handleUpdateMinisteriais($dataMinisteriais, $membroID);

        if (isset($data['foto'])) {
            $this->handlePhotoUpload($data['foto'], $membroID, 'I');
        } else {
            $this->handlePhotoUpload(NULL, $membroID, 'E');
        }
    }

    private function handlePhotoUpload($photo, $membroId, $acao)
    {
        if($acao == 'I'){
            $filePath = $photo->store('fotos', 'minio');
            Storage::disk('minio')->setVisibility($filePath, 'public');

            $membro = MembresiaMembro::find($membroId);
            if ($membro) {
                $membro->foto = Storage::disk('minio')->url($filePath);
                $membro->save();
            }
        } else {
            $membro = MembresiaMembro::find($membroId);
            if ($membro) {
                $membro->foto = '';
                $membro->save();
            }
        }
    }

    private function prepareMembroData(array $data, $vinculo): array
    {
        $cpf = preg_replace('/[^0-9]/', '', $data['cpf']);
        $result = [
            'membro_id' => $data['membro_id'],
            'nome'            => $data['nome'],
            'sexo'            => $data['sexo'],
            'data_nascimento' => Carbon::createFromFormat('Y-m-d', $data['data_nascimento']),
            'estado_civil'  => $data['estado_civil'],
            'nacionalidade'  => $data['nacionalidade'],
            'naturalidade'  => $data['naturalidade'],
            'uf'  => $data['uf'] ?? null,
            'escolaridade_id'  => $data['escolaridade_id'],
            'profissao'  => $data['profissao'],
            'funcao_eclesiastica_id'  => $data['funcao_eclesiastica_id'],
            'cpf'  => $cpf !== '' ? $cpf : null,
            'tipo_documento'  => $data['tipo_documento'],
            'documento'  => $data['documento'],
            'documento_complemento'  => $data['documento_complemento'],
            'data_conversao'  => $data['data_conversao'],
            'data_batismo'  => $data['data_batismo'],
            'data_batismo_espirito'  => $data['data_batismo_espirito'],
            'vinculo'         => $vinculo,
            'has_errors'      => 0
        ];

        if(isset($data['congregacao_id'])) {
            $result['congregacao_id'] = $data['congregacao_id'];
        }

        return $result;
    }

    private function prepareContatoData(array $data): array
    {
        $contatoData = [
            'membro_id' => $data['membro_id'],
            'telefone_preferencial' => preg_replace('/[^0-9]/', '', $data['telefone_preferencial']),
            'telefone_whatsapp'     => preg_replace('/[^0-9]/', '', $data['telefone_whatsapp']),
            'email_preferencial'     => $data['email_preferencial'],
            'cep' => preg_replace('/[^0-9]/', '', $data['cep']),
            'endereco' => $data['endereco'],
            'numero' => $data['numero'],
            'complemento' => $data['complemento'],
            'bairro' => $data['bairro'],
            'cidade' => $data['cidade'],
            'estado' => $data['estado'],
            'observacoes' => $data['observacoes'],
        ];

        // Verifica se as chaves opcionais existem antes de tentar acessá-las
        if (isset($data['telefone_alternativo'])) {
            $contatoData['telefone_alternativo'] = preg_replace('/[^0-9]/', '', $data['telefone_alternativo']);
        }
        if (isset($data['email_alternativo'])) {
            $contatoData['email_alternativo'] = $data['email_alternativo'];
        }

        return $contatoData;
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
            'membro_id' => $data['membro_id'],
        ];
    }

    private function prepareFormacoesData(array $data): array
    {
        $dataFormacoes = [];
        if (isset($data['curso-nome'])) {
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
        if (isset($data['ministerial-departamento'])) {
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

    private function handleUpdateMembro($data)
    {
        $membresia = MembresiaMembro::updateOrCreate(['id' => $data['membro_id']], $data);
        return $membresia->id;
    }

    private function handleUpdateContato($data, $membroId): void
    {
        MembresiaContato::updateOrCreate(['membro_id' => $membroId], $data);
    }

    private function handleUpdateFamiliar($data, $membroId): void
    {
        MembresiaFamiliar::updateOrCreate(['membro_id' => $membroId], $data);
    }

    private function handleUpdateFormacoes(array $formacoes, $membroId): void
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

    private function handleUpdateMinisteriais(array $ministeriais, $membroId): void
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
