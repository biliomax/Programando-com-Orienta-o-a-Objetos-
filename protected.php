<?php

// Carrega as classes
include_once 'classes/Funcionario.class.php';
include_once 'classes/Estagiario.class.php';

// Criação do objeto $pedrinho
$pedrinho = new Estagiario;
$pedrinho->SetSalario(248);
echo 'O Salario do Pedrinho é R$: '. $pedrinho->GetSalario();