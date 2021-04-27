<?php
/**
 * classe Produto
 * implementa Active Record
 */

 class Produto {

    // atributos
    private $data;

    function __get($prop)
    {
        return $this->data[$prop];
    }

    function __set($prop, $value)
    {
        $this->data[$prop] = $value;
    }

    /**
     * método insert
     * armazena o objeto na tabela de produtos
     */
    function inset(){
        // cria instrução SQL de INSERT
        $sql = "INSERT INTO produtos (id, descricao, estoque, preco_custo)".
               " VALUES ('{$this->id}',    '{$this->descricao}', ".
               "    '{$this->estoque}',    '{$this->preco_custo}')";

        // instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
    }

    /**
     * método update
     * altera os dados do objeto na tabela
     */
    function update(){

        // cria instrução SQL UPDATE
        $sql = "UPDATE produtos set ".
               " descricao      = '{$this->descricao}',". 
               " estoque        = '{$this->estoque}',".
               " preco_custo    = '{$this->preco_custo}'".
               " WHERE id       = '{$this->id}'";

        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
    }

    /**
     * método DELETE
     * deleta o objeto da tabela de Produtos
     */
    function delete(){
        // cria instrução SQL de DELETE 
        $sql = "DELETE FROM produtos WHERE id = '{$this->id}'";

        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
    }

    /**
     * método registraCompra
     * registra uma compra, atualiza custo e incrementa o estoque atual
     * @param $unidades      = unidades adquiridas
     * @param $preco_custo  = novo preço de custo
     */
    function registraCompra($unidades, $preco_custo){
        $this->preco_custo  = $preco_custo;
        $this->estoque      = $unidades;
    }

    /**
     * método registraVenda
     * registra uma venda e decrementa o estoque
     * @param $unidades      = unidades vendidas
     */
    public function registraVenda($unidades){
        $this->estoque  -= $unidades;
    }

    /**
     * método calculaPrecoVenda
     * retorna o preco de venda, baseado em uma margem de 30% sobre o custo
     */
    public function calculaPrecoVenda(){
        return $this->preco_custo * 1.3;
    }
 }

 // instancia objeto Produto
 $vinho = new Produto;
 $vinho->id             = 1;
 $vinho->descricao      = 'Vinho Cabernet';
 $vinho->estoque        = 10;
 $vinho->preco_custo    = 10;
 $vinho->inset();

 $vinho->registraVenda(5);

 echo 'estoque:         ' .$vinho->estoque. "<br>\n";
 echo 'preco_custo:     ' .$vinho->preco_custo. "<br>\n";
 echo 'preco_venda:     ' .$vinho->calculaPrecoVenda(). "<br>\n";

 echo '<hr>';

 $vinho->registraCompra(10, 20);
 $vinho->update();

 echo 'estoque:         ' .$vinho->estoque. "<br>\n";
 echo 'preco_custo:     ' .$vinho->preco_custo. "<br>\n";
 echo 'preco_venda:     ' .$vinho->calculaPrecoVenda(). "<br>\n";
 