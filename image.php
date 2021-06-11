<?php

// inclui as classes necessárias
include_once 'app.widgets/TElement.class.php';
include_once 'app.widgets/TImagem.class.php';

// instancia objeto imagem
$gnome = new TImage('app.images/img-google.png');

// exibe objeto imagem
$gnome->show();

// instancia objeto imagem
$gimp = new TImage('app.images/img-google.png');

// exibe objeto imagem
$gimp->show();