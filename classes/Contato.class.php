<?php

class Contato {
    var $Nome;
    var $Telefone;
    var $Email;

    # Grava informações de contato
    function SetContato($Nome, $Telefone, $Email) {
        $this->Nome = $Nome;
        $this->Telefone = $Telefone;
        $this->Email = $Email;
    }

    # Obtém informaçõe de contato
    function GetContato(){
        return "Nome: {$this->Nome}, Telefone: {$this->Telefone}, Email: {$this->Email}";
    }
}