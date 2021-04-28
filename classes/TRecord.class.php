<?php
/**
 * classe TRecord
 * Esta classe provê os métodos necessários para persistir e
 * recuperar objetos da base de dados (Active Record)
 */

 abstract class TRecord {
     
    protected $data;   // array contendo os dados do objeto

    /**
     * método __construct()
     * instancia um Active Record. Se passado o $id, já carrega o objeto
     * @param [$id] = ID do objeto
     */
    public function __construct($id = NULL){
        // se o ID for informado
        if($id){
            // carrega o objeto correspondente
            $object = $this->load($id);
            if($object){
                $this->fromArray($object->toArray());
            }
        }
    }

    /**
     * método __clone()
     * executado quando o objeto for clonado.
     * limpa o ID para que seja gerado um novo ID para o clone.
     */
    public function __clone(){
        unset($this->id);
    }

    /**
     * método __set()
     * executado sempre que uma propriedade for atribuida.
     */
    private function __set($prop, $value){

        // verifica se existe método ser_<propriedade>
        if(method_exists($this, 'set_'.$prop)){
            // executa o método ser_<propriedade>
            call_user_func(array($this, 'set_'.$prop), $value);
        } else {
            // atribui o valor da propriedade
            $this->data[$prop] = $value;
        }
    }

    /**
     * método __get()
     * executado sempre que uma propriedade for requerida
     */
    private function __get($prop)
    {
        // verifica se existe método get_<propriedade>
        if(method_exists($this, 'get_'.$prop)){

            // executa o método get_<propriedade>
            return call_user_func(array($this, 'get_'.$prop));
        } else {
            // retorna o valor da propriedade
            return $this->data[$prop];
        }
    }

 }