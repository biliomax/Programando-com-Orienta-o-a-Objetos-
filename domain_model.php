<?php

/*
 * Class Produto 
 * Representa um Produto a ser vendido
 */

 final class Produto {
     private $descricao;    // descricao do produto
     private $estoque;      // estoque atual
     private $preco_custo;  // preço de custo

    /**
     * método construtor
     * 
     * define alguns valores iniciais
     * @param $decricao = escrição d produto
     * @param $estoque estoque atula 
     * @param $preco_custo = preco de custo
     */
    public function __construct($descricao, $estoque, $preco_custo){
        $this->descricao = $descricao;
        $this->estoque = $estoque;
        $this->preco_custo = $preco_custo;
    }

    /**
     * método registraCompra
     * registra uma compra, atualizada custo e incrementa o estoque atual
     * @param $unidades = unidades adquiridas
     * @param $preco_custo = novo preco de custo
     */
    public function registraCompra($unidades, $preco_custo){
        $this->preco_custo = $preco_custo;
        $this->estoque += $unidades;;
    }

    /**
     * método regtraVenda
     * registra uma venda decrementa o estoque
     * @param $unidades = unidades vendidas
     */
    public function registraVenda($unidades){
        $this->estoque -= $unidades;
    }

    /**
     * método getEstoque
     * retorna a quantidade em estoque
     */
    public function getEstoque(){
        return $this->estoque;
    }

    /**
     * método calculaPrecoVenda
     * retorna o preco de venda, baseado em uma margem de 30% sobre o custo
     */
    public function calculaPrecoVenda(){
        return $this->preco_custo * 1.3;
    }
}

/**
 * Classe Venda
 * Representa uma Venda de Produtos
 */
final class Venda{
    private $itens; // itens da venda

    /**
     * método addItem
     * adiciona um item na venda
     *  @param $quantidade = quantidade vendida
     *  @param $produto = objeto produto
     */
    public function addItem($quantidade, Produto $produto){
        $this->itens[] = array($quantidade, $produto);
    }

    /**
     * método getItems
     * retorna o array de itens da Venda
     */
    public function getItens(){
        return $this->itens;
    }
}

// instancia objeto Venda
$venda = new Venda;

// adiciona alguns produtos
$venda->addItem(3, new Produto('Vinho', 10, 15)); // 58.5
$venda->addItem(2, new Produto('Salame', 20, 20)); // 52
$venda->addItem(1, new Produto('Queijo', 30, 10)); // 13

/**
 * rotina para calcular o total
 * de uma venda e diminuir o estoque
 */
$total = 0;
foreach($venda->getItens() as $item){
    $quantidade = $item[0];
    $produto    = $item[1];

    // Soma o total
    $total += $produto->calculaPrecoVenda() * $quantidade;

    // diminui estoque
    $produto->registraVenda($quantidade);
}

echo "<p>$total</p>";