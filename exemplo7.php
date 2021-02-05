<?php

// interpreta o documento XML
$xml = simplexml_load_file('paises4.xml');

echo "*** Estados *** <br>";
echo '<hr>';

// percorre a lista de estados
foreach($xml->estados->estado as $estado){

    // imprime o estado e a capital
    echo str_pad('<b>Estado :</b> ' . utf8_decode($estado['nome']), 30).
                 '<b> Capital:</b> ' . utf8_decode($estado['capital']) . '<br>';
}
