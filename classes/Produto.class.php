<?php
    class Produto {
        
        var $Codigo;
        var $Descricao;
        private $Preco;
        var $Quantidade;
        const MARGEM = 10;

        # Método costrutor de um Produto
        function __construct($Codigo, $Descricao, $Quantidade, $Preco){
            $this->Codigo = $Codigo;
            $this->Descricao = $Descricao;
            $this->Quantidade = $Quantidade;
            $this->Preco = $Preco;
        }

        // Função
        function ImprimeEtiqueta(){
            print 'Código: '.$this->Codigo. "\n"; 
            print 'Descrição: '.$this->Descricao. "\n";
        }

        # Interceota a otenção de propriedades
        function __get($proprieade){

            echo "Obtendo o valor de '$proprieade' <br>";
            if($proprieade == 'Preco'){
                return $this->$proprieade * (1 + (self::MARGEM/100));
            }
        }

        # Intercepta a chamada à métodos
        function __call($metodo, $parametros){

            echo "Você executou o método: {$metodo} <br>";
            foreach($parametros as $key => $parametro){
                echo "\tParâmetro $key: $parametro <br>";
            }
        }

    }
