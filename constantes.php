<?php

class Biblioteca {
    const Nome = "GTK ";
}

class Aplicacao extends Biblioteca {

    /** Declaração das constantes */
    const Ambiente = "Gnome Desktop ";
    const Versão = "3.8 ";

    /** Método construtor
     * acessa as constantes internamente
     */
    function __construct($Nome) {
        echo parent::Nome . self::Ambiente . self::Versão . $Nome ."<br>";
    }
}


// acessa as contantes externamente
echo Biblioteca::Nome . Aplicacao::Ambiente . Aplicacao::Versão . "<br>";

new Aplicacao('Dia');
new Aplicacao('Gimp');