<?php

namespace App\Services\ServiceClerigosRegiao;

use App\Models\PessoasPessoa;
use Intervention\Image\Facades\Image;

class UpdateClerigosService
{
    public function execute($request, $id)
    {
        $clerigo = PessoasPessoa::findOrFail($id);

        // if ($request->file('image')) {
        //     $image = $request->file('image');  
        //     $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        //     $save_url = 'upload/clerigos/'.$name_gen;
        //     $path = public_path('uploads/clerigos');
        //     // if (!is_dir($path)) {
        //     //     mkdir($path, 0777, true); 
        //     // }

        //     if (!file_exists($path)) {
        //         mkdir($path, 0777, true); // Create directory with permissions, recursively
        //     }


        //     //$paths = public_path('upload/clerigos/' . $name_gen);
        //     Image::make($image)->resize(370,246)->save(public_path('upload/clerigos/' . $name_gen));
        // }
        

        $clerigo->update([
            'nome' => $request->input('nome'),
            'identidade' => $request->input('identidade'),
            'orgao_emissor' => $request->input('orgao_emissor'),
            'data_emissao' => $request->input('data_emissao'),
            //'foto' => $save_url,
            'cpf' => $request->input('cpf'),
            'endereco' => $request->input('endereco'),
            'numero' => $request->input('numero'),
            'complemento' => $request->input('complemento', ''),
            'bairro' => $request->input('bairro'),
            'cidade' => $request->input('cidade'),
            'uf' => $request->input('uf'),
            'pais' => $request->input('pais'),
            'cep' => $request->input('cep'),
            'email' => $request->input('email'),
            'estado_civil' => $request->input('estado_civil'),
            'regiao_id' => 23,
            'sexo' => $request->input('sexo'),
            'formacao_id' => $request->input('formacao_id'),
            'nome_mae' => $request->input('nome_mae', ''),
            'nome_pai' => $request->input('nome_pai', ''),
            'data_nascimento' => $request->input('data_nascimento', ''),
            'telefone_preferencial' => $request->input('telefone_preferencial'),
            'telefone_alternativo' => $request->input('telefone_alternativo'),
            'ctps' => $request->input('ctps', ''),
            'ctps_emissao' => $request->input('ctps_emissao', ''),
            'habilitacao' => $request->input('habilitacao'),
            'habilitacao_categoria' => $request->input('habilitacao_categoria'),
            'habilitacao_emissor' => $request->input('habilitacao_emissor'),
            'habilitacao_uf' => $request->input('habilitacao_uf', ''),
            'identidade_uf' => $request->input('identidade_uf', ''),
            'pispasep' => $request->input('pispasep', ''),
            'pispasep_emissao' => $request->input('pispasep_emissao', ''),
            'residencia_propria' => $request->input('residencia_propria'),
            'residencia_propria_fgts' => $request->input('residencia_propria_fgts'),
            'titulo_eleitor' => $request->input('titulo_eleitor', ''),
            'titulo_eleitor_secao' => $request->input('titulo_eleitor_secao', ''),
            'titulo_eleitor_zona' => $request->input('titulo_eleitor_zona', ''),
            'categoria' => $request->input('categoria', ''),
            'data_consagracao' => $request->input('data_consagracao'),
            'data_ordenacao' => $request->input('data_ordenacao', ''),
            'data_integralização' => $request->input('data_integralização', ''),
            'rol' => $request->input('rol', ''),
        ]);
        
    }
}
