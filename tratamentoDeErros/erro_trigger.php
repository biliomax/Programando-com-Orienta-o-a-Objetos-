<?php
// function Abrir
function Abrir($file = null){
    
    if(!$file){
        trigger_error('Falta o parâmetro com o nome do Arquivo', E_USER_NOTICE);
        return false;
    }

    if(!file_exists($file)){
        trigger_error('Arquivo não existente', E_USER_ERROR);
        return false;
    }

    if(!$retorno = @file_get_contents($file)){
        trigger_error('Impossível ler o arquivo', E_USER_WARNING);
        return $retorno;
    }
}

// função para manipular o erro
function manipular_erro($numero, $mensagem, $arquivo, $linha){
    
    $mensagem = "Arquivo $arquivo : linha $linha # no. $numero : $mensagem <br>";

    // escreve no log todo tipo de erro
    $log = fopen('erros.log', 'a');
    fwrite($log, $mensagem);
    fclose($log);

    // se for uma warning
    if($numero == E_USER_WARNING){
        echo $mensagem;
    }
    // se for um erro fatal
    else if($numero == E_USER_ERROR){
        echo $mensagem;
        die;
    }
}

// define a função manipula_erro como manipuladora dos erros ocorridos
set_error_handler('manipular_erro');

// abrindo um arquivo
$arquivo = Abrir('/tmp/arquivo.dat');
echo $arquivo;