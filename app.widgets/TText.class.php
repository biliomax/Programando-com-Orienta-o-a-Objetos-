<?php
/**
 * classe TText
 * classe para construção de caixas de texto
 */
class TText extends TField {

    private $width;
    private $height;

    /**
     * método construtor
     * instancia um novo objeto
     * @param $name = nome do campo
     */
    public function __construct($name){
        
        // executa o método construtor da classe-pai.
        parent::__construct($name);

        // cria uma TAG HTML do tipo <textarea>
        $this->tag = new TElement('textarea');
        $this->tag->class = 'tfield';   // classe CSS

        // define a altura padrão da caixa de texto
        $this->height = 100;
    }

    /**
     * método setSize()
     * define o tamanho de um campo de texto
     * @param $width    = largura
     * @param $height   = altura
     */
    public function setSize($width, $height){
        
        $this->size = $width;
        $this->height = $height;
    }

    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name    = $this->name; // noma da TAG
        $this->tag->style   = "width:{$this->size};height:{$this->height}"; // tamanho em pixels

        // se o campo não é editável
        if(!parent::getEditable()){
            
            // desabilita a TAG input
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }

        // adiciona conteúdo ao textarea
        $this->tag->add(htmlspecialchars($this->value));

        // exibe a tag
        $this->tag->show();
    }

}