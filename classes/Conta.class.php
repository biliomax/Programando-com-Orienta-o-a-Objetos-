<?php

abstract class Conta {
    
    // Atributos
    var $Agencia;
    var $Codigo;
    var $DataDeCriacao;
    var $Titular;
    var $Senha;
    var $Saldo;
    var $Cancelada;

    // Método Retirar, diminui o saldo em $quantia
    function Retirar($quantia){

        if($quantia > 0){
            $this->Saldo -= $quantia;
        }
    }

    // Método Depositar, aumenta o salario em $quantia
    function Depositar($quantia) {

        if($quantia > 0){
            $this->Saldo += $quantia;
        }
    }

    // Método ObterSaldo - Retorna o Saldo Atual
    function ObterSaldo(){
        return $this->Saldo;
    }

    // Método construtor - Inicializa propriedades.
    function __construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo) {
        
        $this->Agencia = $Agencia;
        $this->Codigo = $Codigo;
        $this->DataDeCriacao = $DataDeCriacao;
        $this->Titular = $Titular;
        $this->Senha = $Senha;

        // Chamada a outro método da classe
        $this->Depositar($Saldo);
        $this->Cancelada = false;
    }

    // Método destrutor - Finaliza objeto
    function __destruct() {
        echo "Objeto Conta {$this->Codigo} de {$this->Titular->Nome} finalizada... <br>";
    }

    // Método abstrato
    #abstract function Transferir($Conta, $Valor);

    // Método abstrato
    final function Transferir($Conta, $Valor){

        if($this->Retirar($Valor)){
            $Conta->Depositar($Valor);
        }

        if($this->Titular != $Conta->Titular){
            $this->Retirar($this->TaxaTransferencia);
        }
    }
    
}