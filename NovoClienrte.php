<?php
/**
 * classe NovoCliente
 * formulário de cadastro de Clientes GTK
 */
class NovoCliente extends GtkWindow {

    private $window;
    private $campos;
    private $labels;

    /**
     * método construtor
     * instancia a janela e constrói os campos
     */
    public function __construct(){

        parent::__construct();
        parent::set_title('Incluir');
        parent::connect_simple('destroy', array('Gtk', 'main_quit'));
        parent::set_defaut_size(400, 240);
        parent::set_border_width(10);
        parent::set_position(GTK::WIN_POS_CENTER);

        $vbox = new GtkBox;

        $this->labels['id'] = new GtkLabel('Código');
        $this->campos['id'] = new GtkEntry;
        $this->campos['id']->set_size_request(80, -1);

        $this->labels['nome'] = new GtkLabel('Nome');
        $this->campos['nome'] = new GtkEntry;
        $this->campos['nome']->set_size_request(240, -1);

        $this->labels['endereco'] = new GtkLabel('Endereço');
        $this->campos['endereco'] = new GtkEntry;
        $this->campos['endereco']->set_size_request(240, -1);

        $this->labels['telefone'] = new GtkLabel('Telefone');
        $this->campos['telefone'] = new GtkComboBox::new_text();
        $this->campos['telefone']->set_size_request(140, -1);

        $this->labels['id_cidade'] = new GtkLabel('Cidade');
        $this->campos['id_cidade'] = new GtkEntry;
        $this->campos['id_cidade']->set_size_request(240, -1);

        $this->campos['id_cidade']->insert_text(0, 'Porto Alegre');
        $this->campos['id_cidade']->insert_text(1, 'São Paulo');
        $this->campos['id_cidade']->insert_text(2, 'Rio de janeiro');
        $this->campos['id_cidade']->insert_text(3, 'Belo Horizonte');

        /**
         * adiciona os labels e campos ao formulário...
         * adiciona alinhamento e posições...
         */
        $vbox->pack_start(new GtkHSeparator, true, true);

        // cria uma caixa de botões
        $buttonbox = new GtkButtonBox;
        $buttonbox->set_layout(Gtk::BUTTONBOX_STATR);

        // cria um botão de salvar
        $botao = GtkButton::new_form_stock(Gtk::STOCK_SAVE);

        // cria um botão de salvar
        $botao->connect_simple('clicked', array($this, 'onSaveClick'));
        $buttonbox->pack_start($botao, false, false);

        // cria um botão de fechar a aplicação
        $botao = GtkButton::new_from_stock('Gtk', 'main_quit');
        $buttonbox->pack_start($botao, false, false);

        $vbox->pack_start($buttonbox, false, false);

        parent::add($vbox);

        // exibe a janela
        parent::show_all();
    }

    /**
     * método onSaveClick()
     * executado quando usuário clica no botão salvar
     */
    public function onSaveClick(){

        // obtém os valores dos campos
        $dados['id']           = $this->campos['id']->get_text();
        $dados['nome']         = $this->campos['nome']->get_text();
        $dados['endereco']     = $this->campos['endereco']->get_text();
        $dados['telefone']     = $this->campos['telefone']->get_text();
        $dados['id_cidade']    = $this->campos['id_cidade']->get_active();

        try {

            // instancia cliente SOAP
            $client = new SoapClient(NULL, array('encoding' =>'ISO-8859-1',
                        'exception' => TRUE,
                        'location'  =>"http://127.0.0.1/server.php",
                        'uri'       =>"http://test-uri/"));
            
            // realiza chamada remota de método
            $retorno = $client->salvar($dados);

            // exibe diálogo de mensagem
            $dialog = new GtkMessageDialog(null, Gtk::DIALOG_MODAL, Gtk::MESSAGE_INFO,
                    Gtk::BUTTONS_OK, 'Registro inserido com sucesso!');
            $dialog->run();
            $dialog->destroy();
        }
        catch(SoapFault $excecao){ // ocorrência de erro

            // exibe diálogo de erro
            $error = new GtkMessageDialog(null, Gtk::DIALOG_MODAL, Gtk::MESSAGE_ERROR,
                    Gtk::BUTTONS_OK, $excecao->getMessage());
            
            $dialog->run();
            $dialog->destroy();
        }
    }
}

// instancia janela NovoCliente
new NovoCliente;
Gtk::Main();