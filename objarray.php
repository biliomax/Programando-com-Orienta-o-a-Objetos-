<?php

# Cria array dados_william
$dados_william['nome'] = 'Willianm Scatola';
$dados_william['idade'] = 22;
$dados_william['profissao'] = 'Controle de Estoque';

# cria array dados_daline
$dados_daline['nome'] = 'Daline DallOglio';
$dados_daline['idate'] = 21;
$dados_daline['profissao'] = 'Almoxarifado';

// Cria objeto william
foreach($dados_william as $chave => $valor){

    // utilizada variáveis variantes
    $william->$chave = $valor;
}


// Cria objeto daline
foreach($dados_daline as $chave => $valor){

    // utilizada variáveis variantes
    $daline->$chave = $valor;
}

echo '<pre>';
echo "{$william->nome} é {$william->profissao} <br>";
echo "{$daline->nome} é {$daline->profissao} <br>";