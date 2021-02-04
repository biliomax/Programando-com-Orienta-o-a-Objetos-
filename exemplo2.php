<?php

// interpreta o documento XML
$xml = simplexml_load_file('paises.xml');

// imprime os atributos do objeto criado
echo 'Nome : '      . $xml->nome ."<br>";
echo 'Idioma : '    . $xml->idioma ."<br>";
echo 'Religiao : '  . $xml->religiao ."<br>";
echo 'Moeda : '     . $xml->moeda ."<br>";
echo 'População : ' . $xml->populacao ."<br>";
