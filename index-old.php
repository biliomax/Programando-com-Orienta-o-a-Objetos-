<?php

switch($_GET['program']){
    
    case 'clientes':
        include 'clientes.php';
        break;
    case 'produtos':
        include 'produtos.php';
        break;
    case 'cidades':
        include 'cidades.php';
        break;
    case 'fabricantes':
        include 'fabricantes.php';
        break;
}