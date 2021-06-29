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
}