<?php
/**
 * clsse TStyle
 * classe para abstração Estilos CSS
 */
class TStyle {
    private $name;  // nome do estilo
    private $properties;    // atributos
    static private $loaded; // array de etilos carregados

    /**
     * método construtor
     * instancia uma tag html
     * @param $name = nome da tag
     */

     public function __construct($name){

        // atribui o nome do estilo
        $this->name = $name;         
     }

     /** 
      * método __set()
      * intercepta as atribuições à propriedades di objeto
      * @param $name    = nome da propriedade
      * @param $value = valor
      */
      public function __set($name, $value){
          
        // substitui o "_" por "-" no nome da propriedade
        $name = str_replace('_', '-', $name);

        // armazena os valores atribuidos ao array properties
        $this->properties[$name] = $value;
      }

      /**
       * método show()
       * exibe a tag na tela
       */
      public function show(){

        // verifica se este estilo já foi carregado
        if(!self::$loaded[$this->name]){

            echo "<stayle type='text/css' media='screen'><br>";

            // exibe a abertura do estilo
            echo ".{$this->name}<br>";
            echo "{<br>";
            
            if($this->properties){
                // percorre as propriedades
                foreach($this->properties as $name => $value){
                    echo "\t {$name}: {$value};<br>";
                }
            }
            echo "}<br>";
            echo "</style><br>";

            // marca o estilo como já carregado
            self::$loaded[$this->name] = TRUE;
        }
      }
}