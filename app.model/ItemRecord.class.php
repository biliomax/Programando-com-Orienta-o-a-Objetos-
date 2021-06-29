<?php

/**
 * classe ItemRecord
 * Active Record para tabela Item
 */

 class ItemRecord extends TRecord {

    private $produto;
    /**
     * método get_descricao()
     * retorna a descrição do produto
     */
    function get_descricao(){

        // instancia ProdutoRecord, carrega
        // na memória o produto de código $this->id_produto
        if(empty($this->produto))
            $this->produto = new ProdutoRecord($this->id_produt);

        // retorna a descrição do produto instanciado
        return $this->produto->descricao;
    }

    /**
     * método get_preco_venda()
     * retorna o preço de venda do produto
     */
    function get_preco_venda(){
        
        // instancia ProdutoRecord, carrega
        // na memória o produto de código $this->id_produt
        if(empty($this->produto))
            $this->produto = new ProdutoRecord($this->id_produto);

        // retorna o preço de venda do produto instaciado
        return $this->produto->preco_venda;
    }
}