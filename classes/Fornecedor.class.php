<?php

class Fornecedor {
    
    var $Codigo;
    var $RazaoSocial;
    var $Endereco;
    var $Cidade;
    var $Contato;

    # Método construtor
    function __construct(){
        // Instancia novo Contato
        $this->Contato = new Contato;
    }

    # Grava contato
    function SetContato($Nome, $Telefone, $Email){
        // Delega chamada de método
        $this->Contato->SetContato($Nome, $Telefone, $Email);
    }

    # Retorna contato
    function GetContato(){
        // Delega chamada de método
        return $this->Contato->GetContato();
    }
}