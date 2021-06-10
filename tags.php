<?php
include_once 'app.widgets/TElement.class.php';

// inicia o documento html
$html = new TElement('html');

// instancia seção head
$head = new TElement('head');
$html->add($head); // adiciona ao html

// define o título da página
$title = new TElement('title');
$title->add('Título da página');
$head->add($title); // adiciona ao head

// inicia o body do html
$body = new TElement('body');
$body->bgcolor='#ffffdd';
$html->add($body); // adiciona ao html

$center = new TElement('center');
$body->add($center);

// instancia um parágrafo
$p = new TElement('p');
$p->align = 'center';
$p->add('Sport Club Internacional');
$center->add($p);   // adiciona ao body

// instancia uma imagem
$img = new TElement('img');
$img->src       = 'app.images/img-google.png';
$img->width     = '120';
$img->heigth    = '120';
$center->add($img); // adiciona ao body

// instancia um sepador horizontal
$hr = new TElement('hr');
$hr->width  = '150';
$hr->align  = 'center';
$center->add($hr);  // adiciona ao body

// instancia um link
$a = new TElement('a');
$a->href = 'https://currencylayer.com/';
$a->add('Visite o Site Oficial');
$center->add($a); // adiciona ao body

// instancia uma quebra de linhas 
$br = new TElement('br');
$center->add($br); // adiciona ao body

// instancia um botão
$input = new TElement('input');
$input->type    = 'button';
$input->value   = 'clique aqui para saber...';

$input->onclick = "alert('Clube do Povo do Rio Grande do Sul!')";
$center->add($input); // adiciona no body

// exibe o html com todos elementos fihos
$html->show();