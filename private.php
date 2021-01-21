<?php

# Carrega classe.
include_once 'classes/Funcionario.class.php';

# Criação de objeto $pedrro
$pedro = new Funcionario;

#$pedrro->Salario = 'Oitocentos e setenta e seis';
$pedro->SetSalario(876);

// Obtém o Salario
echo 'Salario R$: ' . $pedro->GetSalario();
