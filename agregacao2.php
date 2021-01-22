<?php

# Carrega as classes
include_once 'classes/Cesta.class.php';
include_once 'classes/Fornecedor.class.php';
include_once 'classes/Produto.class.php';

# Cria objetos
$fornercedor = new Fornecedor;
$fornercedor->RazaoSocial = 'Produtos Bom Gosto S.A.';

$cesta = new Cesta;
$cesta->AdcionaItem($fornercedor);

# Printar objetos na tela
echo $cesta->CalculaTotal();

