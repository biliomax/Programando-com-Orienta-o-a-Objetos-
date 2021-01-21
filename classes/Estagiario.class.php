<?php

class Estagiario extends Funcionario {

    /** Método GetSalario sobrescrito - Retorna o $Salario com 12% de bonús. */
    function GetSalario() {
        return $this->Salario * 1.12;        
    }
}