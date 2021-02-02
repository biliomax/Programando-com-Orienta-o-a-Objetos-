<?php

# Função de carga automatica - Autoload
function __autoload($classe){

    # Busca classe no diretório de classes...
    include_once "classes/{$classe}.class.php";
}

# Instancia novo Produto
$bolo = new Produto(500, 'Bolo de Fubá', 4, 4.12);
echo 'Código: ' . $bolo->Codigo . '<br>';
echo 'Nome: ' . $bolo->Descricao . '<br>';