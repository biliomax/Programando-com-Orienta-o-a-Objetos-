<?php

class Funcionario {

    private $Codigo;
    public $Nome;
    private $Nascimento;
    protected $Salario;

    // Método SetSalario - Atribui o paramentor $Salario à propriedade $Salario
    function SetSalario($Salario){
        // Verifica se o número é positivo
        if(is_numeric($Salario) and ($Salario > 0)){
            $this->Salario = $Salario;   
        }
    }

    /** Método GetSalario - Retorna o valor da propriedade $Salario. */
    function GetSalario(){
        return $this->Salario;
    }

}