<?php

// interpreta o documento XML
$xml = simplexml_load_file('paises2.xml');

// Alteração de propriedades
$xml->populacao = '220 milhares';
$xml->religiao = 'cristianismo';
$xml->geografia->clima = 'temperado';

// adiciona novo nodo
$xml->addChild('presidente', 'Chapolin Colorado');

// exibido o novo XML
var_dump($xml->asXML());

// grava no arquivo paises2.xml
file_put_contents('paises2.xml', $xml->asXML());

// exibido o novo XML
var_dump($xml->asXML());
