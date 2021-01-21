<?php

// Carrega as classe;
include_once 'classes/Pessoa.class.php';
include_once 'classes/Conta.class.php';

// Criação de objeto $carlos
$carlos = new Pessoa(10, "Carlos da Silva", 1.85, 25, "10/04/1976", "Ensino Médio", 650.00);

echo "<h1>Manipulando o objeto {$carlos->Nome}: </h1>";
echo "<hr>";

echo "{$carlos->Nome} é formado em {$carlos->Escolaridade} <br>";
$carlos->Formar('Técnico em Eletricidade');
echo "{$carlos->Nome} é formado em {$carlos->Escolaridade} <br>";

echo "{$carlos->Nome} possui {$carlos->Idade} anos <br>";
$carlos->Envelhecer(1);
echo "{$carlos->Nome} possui {$carlos->Idade} anos <br>";


// Criação do objeto $conta_carlos
$conta_carlos = new Conta(6677, "CC.123.56", "10/07/02", $carlos, 9876, 567.89);

echo "<h1>Manipulando o objeto {$conta_carlos->Titular->Nome}: </h1>";
echo "<hr>";

echo "O saldo atual é R$ {$conta_carlos->ObterSaldo()} <br>";
$conta_carlos->Depositar(20);
echo "O saldo atual é R$ {$conta_carlos->ObterSaldo()} <br>";
$conta_carlos->Retirar(10);
echo "O saldo atual é R$ {$conta_carlos->ObterSaldo()} <br>";