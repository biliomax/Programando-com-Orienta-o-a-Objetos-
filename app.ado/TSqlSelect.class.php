<?php
/**
 * Autor: Max Moura
 * Data : 10/02/2021
 * classe TSqlSelect
 * Esta classe provê meios para manipulação de uma instrução de SELECT no banco de dados
 */
final class TSqlSelect extends TSqlInstruction {

    // operadores lógicos
    // const AND_OPERATOR = 'AND ';
    // const OR_OPERATOR = 'OR ';

    // Atributos
    private $columns; // array de colunas a serem retornadas.

    /**
     * métodos addColumn
     * adiciona uma coluna a ser retornada pelo SELECT
     * @param $column = coluna da tabela
     */

     public function addColumn($column){
         // adiciona a coluna no array
         $this->columns[] = $column;
     }

     /**
      * método getInstruction()
      * retorna a instrução de SELECT em forma de string.
      */
      public function getInstruction(){
          // monta a instrução de SELECT
          $this->sql = 'SELECT ';

          // monta string com os nomes de colunas
          $this->sql .= implode(',', $this->columns);

          // adiciona a cláusula FROM o nome da tabela
          $this->sql .= ' FROM ' . $this->entity;

          // obtém a cláusula WHERE do objeto criteria.
          if($this->criteria){

            $expression = $this->criteria->dump();

            if($expression){
                $this->sql .= ' WHERE ' . $expression;
            }

            // obtém as propriedades do criterio
            $order = $this->criteria->getProperty('order');
            $limit = $this->criteria->getProperty('limit');
            $offset = $this->criteria->getProperty('offset');

            // obtém a ordenação do SELECT
            if($order){
                $this->sql .= ' ORDER BY ' . $order;
            }
            if($limit){
                $this->sql .= ' LIMIT ' . $limit;
            }
            if($offset){
                $this->sql .= ' OFFSET ' . $offset;
            }
          }
          return $this->sql;
      }
}