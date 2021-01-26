<?php

class Cachorro {
    private $Nascimento;
    
    # Método construtor
    function __construct($nome){
        $this->nome = $nome;
    }

    # tostring, executado sempre que o objeto for impresso
    function __toString(){
        return $this->nome;
    }
}

$toto = new Cachorro('Totó');
$vava = new Cachorro('Daba');

echo $toto .'<br>';
echo $vava .'<br>';
