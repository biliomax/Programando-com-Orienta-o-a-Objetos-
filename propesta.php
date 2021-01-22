<?php

class Aplicacao {
    
    static $Quantidade;
    
    /** Métod Construtor - Incrementa a $Quantidade de Aplicações */
    function __construct($Nome) {
        
        // Incrementa propriedade estática
        self::$Quantidade ++;
        $i = self::$Quantidade;
        echo "Nova Aplicação nr $i: $Nome <br>";
    }
}

# Cria novos objetos
new Aplicacao('Dia');
new Aplicacao('Gimp');
new Aplicacao('Gnumeric');
new Aplicacao('Abiword');
new Aplicacao('Evolution');
echo '<hr>';
echo 'Quantidade de Aplicações = ' . Aplicacao::$Quantidade .'<br>';
