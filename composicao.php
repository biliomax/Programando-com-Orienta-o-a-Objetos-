<?php

# Carrega as classes
include_once 'classes/Fornecedor.class.php';
include_once 'classes/Contato.class.php';

# Cria objetos
$fornercedor = new Fornecedor;
$fornercedor->RazaoSocial = 'Produtos Bom Gosto S.A.';

# Atribui informações de contato
$fornercedor->SetContato('Mauro', '51 1234-5678', 'mauro@bomgosto.com.br');

# Imprime informações
echo $fornercedor->RazaoSocial . '<br>';
echo "Informações de Contato <br>";
echo $fornercedor->GetContato();

