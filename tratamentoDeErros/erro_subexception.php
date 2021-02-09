<?php

// criação de função Abrir
function Abrir($file = null){

    if(!$file){
        throw new ParameterException('Falta o parâmetro com o nome do arquivo');
    }

    if(!file_exists($file)){
        throw new FileNotFoundException('Arquivo não existente');
    }

    if(!$retorno = @file_get_contents($file)){
        throw new FilePermissionException('Impossível ler o arquvivo');
    }
    return $retorno;
}

// definição das subclasses de erro
class ParameterException extends Exception{}
class FileNotFoundException extends Exception{};
class filePermissionException extends Exception{};

// abrindo um arquivo
// tratamento de exceções
try {
    $arquivo = Abrir('/tmp/arquivo.dat');
    echo $arquivo;
}

// captura o erro
catch (ParameterException $excecao){
    // não faz nada
}

catch (FileNotFoundException $excecao){
    echo '<pre>';
    var_dump($excecao->getTrace());
    echo "finalizando aplicação... \n";
    die;
}

catch (filePermissionException $excecao){
    echo $excecao->getFile() . ' : ' . $excecao->getLine() . ' # '. $excecao->getMessage();
}