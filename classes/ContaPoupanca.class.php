<?php

Final class ContaPoupanca extends Conta {

    Var $Aniversario;
    
    /** Método construtor (sobrescrito) - Agora, também inicializa a variável $Aniversario */
    function __construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo, $Aniversario) {

        // Chamada do método construtor da classe-pai
        parent::__construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo);
        
        $this->Aniversario = $Aniversario;
    }

    // Método Retirar (sobrescrito) - Verifica se há saldo para retirar tal $quantia.
    function Retirar($quantia) {
        
        if($this->Saldo >= $quantia){
            // Executa método da classe-pai.
            parent::Retirar($quantia);
        } else {
            echo "Retirada não permitida... <br>";
            return false;
        }
        // Retirada permitida
        return true;
    }

    // Implementaçã de método abstrato da classe Conta.
    function Transferir($Conta, $Valor) {
        
        if($this->Retirar($Valor)){
            $Conta->Depositar($Valor);
        }
    }
}