<?php

/**
 * classe ProdutoGateway
 * implementa Table Data Gateway
 */

 class ProdutoGateway {

    /**
     * método insert
     * insere dados na tabela de Produtos
     *  @param $id          = ID do produto
     *  @param $descricao   = descrição do produto
     *  @param $estoque     = estoque atual
     *  @param $preco_custo = preco de custo
     */

     function insert($id, $descricao, $estoque, $preco_custo){
         
        // cria instrução SQL de INSERT
        $sql = "INSERT INTO Produtos (id, descricao, estoque, preco_custo)".
               " VALUES ('$id', '$descricao', '$estoque', '$preco_custo')";

        // instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
     }

     /**
      * método update
      * altera os dados na tabela de Produtos
     *  @param $id          = ID do produto
     *  @param $descricao   = descrição do produto
     *  @param $estoque     = estoque atual
     *  @param $preco_custo = preco de custo
     */     
    function update($id, $descricao, $estoque, $preco_custo){

        // Cria instrução SQL de UPDATE
        $sql = "UPDATE produtos set descricao = '$descricao', ".
               " estoque = '$estoque', preco_custo = '$preco_custo' ".
               " WHERE id = '$id'";

        // instancia objeto PDO 
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
    }



 }