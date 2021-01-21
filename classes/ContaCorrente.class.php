<?php

class ContaCorrente extends Conta {

    Var $Limite;
    
    /** Método construtor (sobrescrito) - Agora, também inicializa a variável $Limite */
    function __construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo, $Limite) {

        // Chamada do método construtor da classe-pai
        parent::__construct($Agencia, $Codigo, $DataDeCriacao, $Titular, $Senha, $Saldo);
        
        $this->Limite = $Limite;
    }

    // Método Retirar (sobrescrito) - Verifica se $quantia retirada está dentro do limite.
    function Retirar($quantia) {

        // Imposto sobre movimentação financeira.
        $cpmf = 0.05;
        
        if( ($this->Saldo + $this->Limite) >= $quantia) {

            // Executa método da classe-pai.
            parent::Retirar($quantia);

            // Debita o imposto
            parent::Retirar($quantia * $cpmf);

        } else {
            echo "Retirada não permitida... <br>";
            return false;
        }

        // Retirada permitida
        return true;
    }

}