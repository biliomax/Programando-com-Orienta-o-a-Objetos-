<?php
/**
 * classe ClienteRecord
 * Active Record para tabela Cliente
 */
class ClienteRecord extends TRecord {

    private $cidade;

    /**
     * método get_nome_cidade()
     * executado sempre se for acessada a propriedade "nome_cidade"
     */
    function get_nome_cidade(){

        // instancia CidadeRecord, carrega
        // na memória a cidade de código $this->id_cidade
        if(empty($this->cidade))
            $this->cidade = new CidadeRecord($this->id_cidade);

        // retorna o objeto instaciado
        return $this->cidade->nome;
    }
}