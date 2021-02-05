<?php

// interpreta o documento XML
$xml = simplexml_load_file('paises4.xml');

echo "*** Estados *** <br>";
echo '<hr>';

// percorre os estados
foreach($xml->estados->estado as $estado){

    // percorre os atributo de cada estado
    foreach($estado->attributes() as $key => $value){
        echo utf8_decode($key.' : '.$value) .'<br>'; // utf8_decode formata os caracteres especiais 
    }
}
