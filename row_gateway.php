<?php
/**
 * classe ProdutoGateway
 * implementa Row Data Gateway
 */

 class ProdutoGateway{
    // Atributos
    private $data;

    function __get($prop) {
        return $this->data[$prop];
    }

    function __set($prop, $value) {
        return $this->data[$prop] = $value;
    }

    /**
     * método insert
     * armazena o objeto na tabela de produtos
     */
     function insert(){

        // cria instrução SQL de INSERT
        $sql = "INSERT INTO produtos (id, descricao, estoque, preco_custo)".
               " VALUES ('{$this->id}',      '{$this->descricao}',".
               "         '{$this->estoque}', '{$this->preco_custo}')";
        echo $sql . "<br>\n";

        // instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
     }

     /**
      * método update
      * altera os dados do objeto na tabela de Produtos
      */
      function update(){

        // cria instrução SQL de UPDATE
        $sql = "UPDATE produtos set ". 
        " descricao     = '{$this->descricao}', " .
        " estoque       = '{$this->estoque}', " .
        " preco_custo   = '{$this->preco_custo}' " .
        " WHERE id      = '{$this->id}'";

        echo $sql . "<br>\n";

        // instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
      }

      /**
       * método delete
       * deleta o objeto da tabela de Produtos
       */
      function delete(){

        // cria instrução SQL DELETE
        $sql = "DELETE FROM produtos WHERE id = '{$this->id}'";

        echo $sql . "<br>\n";

        //instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
      }

      /**
       * método getObject
       * carrega um objeto a partir da tabela de produtos
       */
      function getObject($id){

        // cria instrução SQL de SELECT
        $sql = "SELECT * FROM produtos WHERE id = '{$id}'";
        echo $sql . "<br>\n";

        // instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $result = $conn->query($sql);
        $this->data = $result->fetch(PDO::FETCH_ASSOC);
        unset($conn);
      }
    }

    // insere produtos na tabela de dados
    $vinho = new ProdutoGateway;
    $vinho->id              = 1;
    $vinho->descricao       = 'Vinho Cabernet';
    $vinho->estoque         = 10;
    $vinho->preco_custo     = 10;
    $vinho->insert();

    $salame = new ProdutoGateway;
    $salame->id             = 2;
    $salame->descricao      = 'Salame';
    $salame->estoque        = 20;
    $salame->preco_custo    = 20;
    $salame->insert();

    // recupera um objeto e realiza alteração
    $objeto = new ProdutoGateway();
    $objeto->getObject(2);
    $objeto->estoque  = $objeto->estoque * 2;
    $objeto->descricao  = 'Salaminho Italiano';
    $objeto->update();

    // exclui o produto vinho da tabela
    $vinho->delete();
