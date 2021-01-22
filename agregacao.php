<?php

# Carrega as classes
include_once 'classes/Cesta.class.php';
include_once 'classes/Produto.class.php';

# Cria objetos
$produto1 = new Produto;
$produto2 = new Produto;
$produto3 = new Produto;
$produto4 = new Produto;

$produto1->Codigo = 1;
$produto1->Descricao = 'Ameixa';
$produto1->Preco = 1.40;

$produto2->Codigo = 2;
$produto2->Descricao = 'Morango';
$produto2->Preco = 2.24;

$produto3->Codigo = 3;
$produto3->Descricao = 'Abacaxi';
$produto3->Preco = 2.86;

$produto4->Codigo = 4;
$produto4->Descricao = 'Laranja';
$produto4->Preco = 1.14;

# Criação do objeto Cesta
$cesta = new Cesta;
$cesta->AdcionaItem($produto1);
$cesta->AdcionaItem($produto2);
$cesta->AdcionaItem($produto3);
$cesta->AdcionaItem($produto4);

# Printar objetos na tela
echo $cesta->CalculaTotal();
echo '<br>';
echo $cesta->ExibeLista();
