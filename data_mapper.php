<?php
/**
 * class Produto
 * representa um Produto a ser vendido
 */
final class Produto {

    // atributos
    private $descricao;     // descrição do produto
    private $estoque;       // estoque atual
    private $preco_custo;    // preço de custo

    /**
     * método construtor
     * define alguns valores iniciais
     * @param $descricao        = descrição do produto
     * @param $estoque          = estoque atual
     * @param $preco_custo      = preço de custo
     */
    public function __construct($descricao, $estoque, $preco_custo){
        $this->descricao    = $descricao;
        $this->estoque      = $estoque;
        $this->preco_custo  = $preco_custo;
    }

    /**
     * método getDescricao
     * retorna a descrição do produto
     */
    public function getDescricao(){
        return $this->descricao;
    }
}

/**
 * classe  Venda
 * representa uma Venda de Produtos
 */
final class Venda{
    
    // atributos
    private $id;
    private $itens; // itens da cesta
    
    /**
     * método construtor
     * instancia uma nova venda
     * @param $id   = Identificador
     */
    function __construct($id){
        $this->id = $id;
    }

    /**
     * método getID
     * retorna o identificador
     */
    function getID(){
        return $this->id;
    }
    
    /**
     * método addItem
     * adciona um item na cesta
     * @param $quantidade   = quantidade vendida
     * @param $produto      = objeto produto
     */
    public function addItem($quantidade, Produto $produto){
        $this->itens[] = array($quantidade, $produto);
    }

    /**
     * método getItems
     * retorna o array de itens da cesta
     */
    public function getItens(){
        return $this->itens;
    }
}

/**
 * class Venda Mapper
 * Implementa Data Mapper para a classr Venda
 */
final class VendaMapper {

    function insert(Venda $venda){
        $id     = $venda->getID();
        $date   = date("Y-m-d");

        // insere a venda no banco de dados
        $sql = "INSERT INTO venda (id, data) VALUES ('$id', '$date')";
        echo $sql . "<br>\n";

        // percorre os itens vendidos
        foreach($venda->getItens() as $item){
            $quantidade = $item[0];
            $produto    = $item[1];
            $descricao  = $produto->getDescricao();

        // insere os itens da venda no banco de dados
        $sql = "INSERT INTO venda_items (ref_venda, produto, quantidade)".
               " VALUES ('$id', '$descricao', '$quantidade')";
            echo $sql . "<br>\n";
        }
    }
}

// instancia objeto Venda
$venda = new Venda(1000);

// adciona alguns produtos
$venda->addItem(3, new Produto('Vinho', 10, 15));
$venda->addItem(2, new Produto('Salame', 20, 20));
$venda->addItem(1, new Produto('Queijo', 30, 10));

// Data Mapper persiste a venda
VendaMapper::insert($venda);

