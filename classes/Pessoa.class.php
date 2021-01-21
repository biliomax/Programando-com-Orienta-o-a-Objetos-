<?php

class Pessoa {
    var $Codigo;
    var $Nome;
    var $Altura;
    var $Idade;
    var $Nascimento;
    var $Escolaridade;
    var $Salario;

    /** Método crescer
     * aumenta a altura em $crecismento.
    */
    function Crescer($crecismento){

        if($crecismento > 0){
            $this->Altura += $crecismento;
        }
    }

    /** Método formar
     * aultera a Escolaridade para $titulacao
     */
    function Formar($titulacao){
        $this->Escolaridade = $titulacao;
    }

    /** Método Envelhecer
     * Aumenta a Idade em $anos
     */
    function Envelhecer($anos){

        if($anos > 0){
            $this->Idade += $anos;
        }
    }

    // Método construtor - Inicializa propriedades.
    function __construct($Codigo, $Nome, $Altura, $Idade, $Nascimento, $Escolaridade, $Salario) {
        $this->Codigo = $Codigo;
        $this->Nome = $Nome;
        $this->Altura = $Altura;
        $this->Idade = $Idade;
        $this->Nascimento = $Nascimento;
        $this->Escolaridade = $Escolaridade;
        $this->Salario = $Salario;
    }

    // Método destrutor - Finaliza Objeto
    function __destruct() {
        echo "Objeto {$this->Nome} finalizado... <br>";
    }

}