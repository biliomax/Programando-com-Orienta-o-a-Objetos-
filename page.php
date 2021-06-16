<?php

$option = $_GET['option'];

switch($option){
    case 'listar':
        echo 'listando registro';
        break;
    case 'incluir':
        echo 'inclindo registro';
        break;
    case 'alterar':
        echo 'alterando registro';
        break;
    case 'excluir':
        echo 'excluindo registro';
        break;
}