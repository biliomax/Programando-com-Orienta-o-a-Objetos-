<?php

// Carrega as classses
include_once 'classes/Funcionario.class.php';
include_once 'classes/Estagiario.class.php';

// Cria objeto Funcionario
$pedrinho = new Funcionario;
$pedrinho->Nome = 'Pedrinho';

// Cria objeto Estagiario
$mariana = new Estagiario;
$mariana->Nome = 'Mariana';

// Imprime propriedade Nome
echo $pedrinho->Nome;
echo '<br>';
echo $mariana->Nome;