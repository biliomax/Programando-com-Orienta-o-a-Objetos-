<?php

// interpreta o documento XML
$xml = simplexml_load_file('paises.xml');

// exibe as informações do objeto criado
echo '<pre>';
var_dump($xml);