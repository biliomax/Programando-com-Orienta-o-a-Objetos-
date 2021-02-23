<?php
/**
 * classe TSqlDelete
 * Esta classe provê meios para manipulação de uma instrução de DELETE no banco de dados
 */
class TSqlDelete extends TSqlInstruction {

    /**
     * método getInstruction()
     * retorna a instrução de DELETE em forma de string
     */

    // implentação da classe pai
    function getInstruction(){
        
        // monta a string de DELETE
        $this->sql = "DELETE FORM {$this->entity}";

        // retorna a clásula WHERE do objeto $this->criteria
        if($this->criteria){
            $expression = $this->criteria->dump();
            if($expression){
                $this->sql .= ' WHERE ' . $expression;
            }
        }
        return $this->sql;
    }
}