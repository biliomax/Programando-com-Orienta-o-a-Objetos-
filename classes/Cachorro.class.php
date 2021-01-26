<?php

class Cachorro {
    
    private $Nascimento;

    # Método contrutor
    function __construct($nome){    
        $this->nome = $nome;
    }

    # Intercepta atribuição
    function __set($propriedade, $valor){
        
        if($propriedade == "Nascimento"){
            
            # Verifica se valor é dividido em 3 partes separadas por '/'
            if(count(explode('/', $valor)) == 3){
                echo "Dado '$valor', atribuido à '$propriedade' <br>";
                $this->$propriedade = $valor;
            } else {
                echo "Dado '$valor', não atribuido à '$propriedade' <br>";
            }
        } else {
            $this->$propriedade = $valor;
        }
    }
}