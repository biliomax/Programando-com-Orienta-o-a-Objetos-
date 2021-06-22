<?php
/**
 * função __autoload()
 * carrega uma classe quando ela é necessária,
 * ou seja, quando ela é instancia pela primeira vez.
 */
function __autoload($classe){

    if(file_exists("app.widgets/{$classe}.class.php")){

        include_once "app.widgets/{$classe}.class.php";
    }
}

/**
 * função conv_data_to_br()
 * converte uma dta para o formato dd/mm/yyyy
 * @param $data = data no formato yyyy/mm/dd
 */
function conv_data_to_br($data){

    // captura as partes da data
    $ano = substr($data,0,4);
    $mes = substr($data,5,2);
    $dia = substr($data,8,4);
    
    // retorna a data resultante
    return"{$dia}/{$mes}/{$ano}";
}