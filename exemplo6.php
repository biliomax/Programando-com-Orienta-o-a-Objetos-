<?php

// interpreta o documento XML
$xml = simplexml_load_file('paises3.xml');

echo 'Nome : ' . $xml->nome . '<br>';
echo 'Idioma : ' . $xml->idioma . '<br>';

echo '<hr>';
echo "*** Estados ***";

/* Você pode acessar um estado diretamente pelo seu índice
* echo $xml->estados->nome as $estado
*/
foreach($xml->estados->nome as $estado){
    echo 'Estado : ' . utf8_decode($estado) . '<br>';
}

