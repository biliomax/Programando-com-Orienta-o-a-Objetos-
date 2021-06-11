<?php

// inclui as classes necessárias
include_once 'app.widgets/TElement.class.php';
include_once 'app.widgets/TParagraph.class.php';

// instancia objeto parágrafo
$texo1 = new TParagraph('teste1<br>teste1<br>teste1');
$texo1->setAlign('left');

// exibe objeto
$texo1->show();

// instancia objeto parágrafo
$texo2 = new TParagraph('teste2<br>teste2<br>teste2');
$texo2->setAlign('right');

// exibe objeto
$texo2->show();