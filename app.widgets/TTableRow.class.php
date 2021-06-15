<?php
/**
 * classe TTableRow
 * responsável pela exibição de um tabela
 */
class TTableRow extends TElement {

    /**
     * método constutor
     * instancia uma nova linha
     */
    public function __construct(){
        parent::__construct('tr');        
    }

    /**
     * método addCell
     * agrega um novo objeto célula (TTableCell) à linha
     * @param $value = conteúdo da célula
     */
    public function addCell($value){

        // imstancia objeto célula
        $cell = new TTableCell($value);
        parent::add($cell);

        // retorna o objeto instanciado
        return $cell;
    }
}