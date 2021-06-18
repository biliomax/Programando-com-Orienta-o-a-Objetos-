<?php
/**
 * classe TField
 * classe base para construção dos widgets para formulários
 */
abstract class TField {

    protected $name;
    protected $size;
    protected $value;
    protected $editable;
    protected $tag;

    /**
     * método construtor
     * instancia um campo do formulário
     * @param $name = nome do campo
     */
    public function __construct()
    {
        // define algumas características iniciais
        self::setEditable(true);
        self::setName($name);
        self::setSize(200);

        // instancia um estilo CSS chamado tfield
        // que será utilizado pelos campos do formulário
        $style1 = new TStyle('tfield');
        $style1->border           = 'solid';
        $style1->border_color     = '#a0a0a0';
        $style1->border_width     = '1px';
        $style1->z_index          = '1';

        $style2 = new TStyle('tfield_disabled');
        $style2->border           = 'solid';
        $style2->border_color     = '#a0a0a0';
        $style2->border_width     = '1px';
        $style2->backgroun_color  = '#e0e0e0';
        $style2->color            = '#a0a0a0';

        $style1->show();
        $style2->show();

        // cria uma tag HTML do tipo <input>
        $this->tag = new TElement('input');
        $this->tag->class = 'tfield'; // classe CSS
    }

    /**
     * método setName()
     * define o nome do widget
     * @param $name = nome do widget
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * método getName()
     * retorna o nome do widget
     */
    public function getName(){
        return $this->name;
    }

    /**
     * método setValue()
     * define o valor de campo
     * @param $value = valor do campo
     */
    public function setValue($value){
        $this->value = $value;
    }

    /**
     * método getValue()
     * retorna o valor de um campo
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * método setEditable()
     * define se o campo poderá ser editado
     * @param $editable = TRUE ou FALSE
     */
     public function setEditable($editable){
        $this->editable = $editable;
     }

     /**
      * método getEditable()
      * retorna o valor da propriedade $editable
      */
      public function getEditable(){
          return $this->editable;
      }

      /**
       * método setProperty()
       * define uma propriedade para o campo
       * @param $name = nome da propriedade
       * @param $valor = valor da propriedade
       */
      public function setProperty($name, $value){

        // define uma propriedade de $this->tag
        $this->tag->$name = $value;
      }

      /**
       * método setSize()
       * define a largura do widget
       * @param $size = tamnho em pixels
       */
      public function setSize($size){
          $this->size = $size;
      }
}