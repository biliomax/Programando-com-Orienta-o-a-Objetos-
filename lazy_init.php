<?php
/**
 * classe Pessoa
 */
class Pessoa {
    private $nome; // nome da pessoa
    private $cidadadeID; // ID da cidade.

    /**
     * método construtor
     * instancia o objeto, define alguns atributos
     * @param $nome = nome da pessoa
     * @param $cidadeID = codigo da cidade
     */

    function __construct($nome, $cidadeID){

        $this->nome     = $nome;
        $this->cidadeID = $cidadeID;
    }

    /*
    * método __get
    * intercepta a obtenção de propriedades
    * @param $propriedade = nome da propriedade 
    */

    function __get($propriedade){

        if($propriedade == 'cidade')
        {
            return new Cidade($this->cidadadeID);
        }
    }
}

/**
 * classe Cidade
 */
class Cidade {
    private $id;
    private $nome; // nome da cidade

    /**
     * método construtor
     * instancia o objeto
     * @param $id = ID da cidade
     */

     function __construct($id) {
         
        $data[1] = 'Porto Alegre';
        $data[2] = 'São Paulo';
        $data[3] = 'Rio de Janeiro';
        $data[4] = 'Belo Horizonte';

        // atribui o id
        $this->id = $id;

        // define seu nome
        $this->setNome($data[$id]); // Essa linha tem um problema
     }

      /*
      * método setNome
      * define o nome da cidade
      * @param $nome = nome da cidade
      */

        function setNome($nome)
        {
            $this->nome = $nome;
        }

       /*
       * método getNome
       * retorna o nome da cidade
       */
       function getNome()
       {
        return $this->nome;
       }
}

// instancia dois objetos Pessoa
$maria = new Pessoa('Maria da Silva', 3);
$pedro = new Pessoa('Pedro Cardoso', 2);

// exibe o nome da cidade de cada Pessoa
echo $maria->cidade->getNome() . "<br>\n";
echo $pedro->cidade->getNome() . "<br>\n";

// exibe o atributo cidade
echo '<pre>';
print_r($maria->cidade);
