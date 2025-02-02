<?php

namespace App\Observers;

use App\Models\PessoasPessoa;

class ClerigosObserver
{
    public function creating(PessoasPessoa $pessoasPessoas)
    {


        if ($pessoasPessoas->cep) {
            $pessoasPessoas->cep = preg_replace('/[^\d]/', '', $pessoasPessoas->cep);
        }

        if ($pessoasPessoas->cpf) {
            $pessoasPessoas->cpf = preg_replace('/[^\d]/', '', $pessoasPessoas->cpf);
        }

        if ($pessoasPessoas->telefone_preferencial) {
            $pessoasPessoas->telefone_preferencial = preg_replace('/[^\d]/', '', $pessoasPessoas->telefone_preferencial);
        }
        if ($pessoasPessoas->telefone_alternativo) {
            $pessoasPessoas->telefone_alternativo = preg_replace('/[^\d]/', '', $pessoasPessoas->telefone_alternativo);
        }

        if ($pessoasPessoas->celular) {
            $pessoasPessoas->celular = preg_replace('/[^\d]/', '', $pessoasPessoas->celular);
        }
        if ($pessoasPessoas->titulo_eleitor) {
            $pessoasPessoas->titulo_eleitor = preg_replace('/[^\d]/', '', $pessoasPessoas->titulo_eleitor);
        }
        if ($pessoasPessoas->identidade) {
            $pessoasPessoas->identidade = preg_replace('/[^\d]/', '', $pessoasPessoas->identidade);
        }
    }

    public function updating(PessoasPessoa $pessoasPessoas)
    {

        if ($pessoasPessoas->cep) {
            $pessoasPessoas->cep = preg_replace('/[^\d]/', '', $pessoasPessoas->cep);
        }

        if ($pessoasPessoas->cpf) {
            $pessoasPessoas->cpf = preg_replace('/[^\d]/', '', $pessoasPessoas->cpf);
        }


        if ($pessoasPessoas->telefone_preferencial) {
            $pessoasPessoas->telefone_preferencial = preg_replace('/[^\d]/', '', $pessoasPessoas->telefone_preferencial);
        }
        if ($pessoasPessoas->telefone_alternativo) {
            $pessoasPessoas->telefone_alternativo = preg_replace('/[^\d]/', '', $pessoasPessoas->telefone_alternativo);
        }


        if ($pessoasPessoas->celular) {
            $pessoasPessoas->celular = preg_replace('/[^\d]/', '', $pessoasPessoas->celular);
        }

        if ($pessoasPessoas->titulo_eleitor) {
            $pessoasPessoas->titulo_eleitor = preg_replace('/[^\d]/', '', $pessoasPessoas->titulo_eleitor);
        }

        if ($pessoasPessoas->identidade) {
            $pessoasPessoas->identidade = preg_replace('/[^\d]/', '', $pessoasPessoas->identidade);
        }
    }
}
