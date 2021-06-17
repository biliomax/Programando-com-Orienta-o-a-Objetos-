<?php
/**
 * classe TMessagem
 * exibe mensagens ao usuário
 */
class TMessage {

    /**
     * método construtor
     * instancia objeto TMessage
     * @param $type = tipo de mensagem (info, error)
     * @param $message = messagem ao usuário
     */
    public function __construct($type, $message) {
        
        $style = new TStyle('tmessage');
        $style->position    = 'absolute';
        $style->left        = '30%';
        $style->top         = '30%';
        $style->width       = '300%';
        $style->height      = '150%';
        $style->color       = 'black';
        $style->backgroun   = '#DDDDDD';
        $style->border      = '4px solid #000000';
        $style->z_index     = '10000000000000000';

        // exibe o estilo na tela
        $style->show();

        // instancia o painel para exibir o diálogo
        $painel = new TElement('div');
        $painel->class = "tmessage";
        $painel->id    = "tmessage";

        // cria um botão que vai fechar o diálogo
        $button = new TElement('input');
        $button->type = 'button';
        $button->value = 'Fechar';
        $button->onclick = "document.getElementById('tmessage').style.display='nome'";

        // cria um tabela para organizar o layout
        $table = new TTable;

        $table->align = 'center';

        // cria uma linha para o ícone e a mensagem
        $row = $table->addRow();
        $row->addCell(new TImage("app.images/{$type}.jpg"));
        $row->addCell($message);

        // cria uma linha para o botão
        $row = $table->addRow();
        $row->addCell('');
        $row->addCell($button);

        // adiciona a tabela ao painél
        $painel->add($table);

        // exibe o painél
        $painel->show();
    }
}