<?php

// Carrega as classes
include_once 'classes/Pessoa.class.php';
include_once 'classes/Conta.class.php';
include_once 'classes/ContaPoupanca.class.php';

# Criação do objeto $carlos
$carlos = new Pessoa(10, "Carlos da Silva", 1.85, 25, 72, "Ensino Médio", 650.00);
$conta = new Conta(6677, "CC.123.56", "10/07/02", $carlos, 9876, 500.00, '10/07');

echo "<hr>";