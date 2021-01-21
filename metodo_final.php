<?php

// Carrega as classes
include_once 'classes/Conta.class.php';
include_once 'classes/ContaCorrente.class.php';

class ContaCorrenteEspecial extends ContaCorrente {
    function Depositar($Valo)
    {
        echo "Sobrescrevendo método Depositar. <br>";
        parent::Depositar($Valo);
    }

    function Transferir($Conta, $Valo) {

        echo "Sobrescrevendo método Transferir. <br>";
        parent::Transferir($Conta, $Valo);
    }
}

