<?php
/**
 * classe VendaRecord
 * Active Record para tabela Venda
 */
class VendaRecord extends TRecord {

    private $itens; // array de objetos do tipo ItemRecord

    /**
     * funçao addItem()
     * adiciona um itém (produto) à venda
     */
    public function addItem(ItemRecord $item){

        $this->itens[] = $item;
    }

    /**
     * função store()
     * aemazena uma venda e seus itens no banco de dados
     */
    public function store(){

        // armazena a venda
        parent::store();

        // percorre os itens da venda
        foreach($this->itens as $item){

            $item->id_venda = $this->id;
            // armazena o item
            $item->store();
        }
    }

    /**
     * função get_itens()
     * retorna os itens da venda
     */
    public function get_itens(){

        // instancia um repositório de Item
        $repositorio = new TRepository('Item');

        // define o critério de seleção
        $criterio = new TCriteria;
        $criterio->add(new TFilter('id_venda', '=', $this->id));

        // carega a coleção de itens
        $this->itens = $repositorio->load($criterio);

        // return od itens
        return $this->itens;
    }

    /**
     * método get_cliente()
     * retorna o objeto cliente vinculado à venda
     */
    function get_cliente(){

        // instancia ClienteRecord, carrega
        // na memória o cliente de código $this->id_cliente
        $cliente = new ClienteRecord($this->id_cliente);

        // retorna o objeto instanciado
        return $cliente;
    }
}