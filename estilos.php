<?php
// inclui classe TStyle
include_once 'app.widgets/TStyle.class.php';

// instancia objetos TStyle
// define características de um estilo chamdo texto
$estilo1 = new TStyle('texto');
$estilo1->font_family       = 'arial, verdana,sans-serif';
$estilo1->font_style        = 'normal';
$estilo1->font_weight       = 'bold';
$estilo1->color             = 'white';
$estilo1->text_decoration   = 'none';
$estilo1->font_size         = '10pt';

// instancia objetos TStyle
// define características de um estilo chamdo celula
$estilo2 = new TStyle('celula');
$estilo2->backgroun_color   = 'white';
$estilo2->padding_top       = '10px';
$estilo2->padding_bottom    = '10px';
$estilo2->padding_left      = '10px';
$estilo2->padding_right     = '10px';
$estilo2->margin_left       = '10px';
$estilo2->width             = '10px';
$estilo2->height            = '10px';
#echo "<pre>";
// exibe estilos na tela
$estilo1->show();
$estilo2->show();

// // exibe estilos na tela
// $estilo1->show();
// $estilo2->show();