<?php
/**
 * classe TImage
 * classe para exibição de imagens
 */
class TImage extends TElement {
    private $source;    // localização da imagem
    #private $tag;       // objeto TElement

    /**
     * método construtor
     * instancia objeto TImage
     * @param $source = localização da imagem
     */
    public function __construct($source) {
        
        // atribui a localização da image
        #$this->source = $source;
        // instancia objeto TElemnt
        #$this->tag  = new TElement('img');
        
        parent:: __construct('img');
        // atribui a localizaçao da imagem
        $this->src = $source;
        $this->border = 0;
    }

    /**
     * método show()
     * exibe imagem na tela
     */
    // public function show(){
    //     // define algumas propriedades da tag
    //     $this->tag->src = $this->source;
    //     $this->tag->border = 0;

    //     // exibe tag na tela
    //     $this->tag->show();
    // }
}