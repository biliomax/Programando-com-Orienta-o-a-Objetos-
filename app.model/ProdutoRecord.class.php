<?php
/**
 * classe ProdutoRecord
 * Active Record para tabela Produto
 */
class ProdutoRecord extends TRecord {

    private $fabricante;

    /**
     * método get_nome_fabricante()
     * retorna o nome do fabricante do produto
     */
    function get_nome_fabricante(){

        // instancia FabricanteRecord, carrega
        // na memória a fabricante de código $this->id_fabricante
        if(empty($fabricante))
            $this->fabricante = new FabricanteRecord($this->id_fabricante);
        // retorna o nome do fabricante
        return $this->fabricante->nome;
    }
}