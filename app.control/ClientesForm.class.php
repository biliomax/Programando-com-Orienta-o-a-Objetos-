<?php
/**
 * classe ClientesForm
 * formulário de cadastro de Clientes
 */
class ClientesForm extends ClientesList {

    private $form; // formulário
    /**
     * método construtor
     * cria a página e o formulário de cadastro
     */
    function __construct(){
        
        parent::__construct();

        // instancia um formulário
        $this->form = new TForm('form_clientes');

        // instnacia uma tabela
        $table = new TTable;

        // adiciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $codigo     = new TEntry('id');
        $nome       = new TEntry('nome');
        $endereco   = new TEntry('endereco');
        $telefone   = new TEntry('telefone');
        $cidade     = new TCombo('id_cidade');

        // define alguns atributos para os campos do formulário
        $codigo->setEditable(FALSE);
        $codigo->setSize(100);
        $nome->setSize(300);
        $endereco->setSize(300);

        // carrega as cidades do banco de dados
        TTransaction::open('my_livro');

        // instancia um repositório de Cidade
        $repository = new TRepository('Cidade');

        // carrega todos os objetos
        $collection = $repository->load(new TCriteria);

        // adiciona objetos na combo
        foreach($collection as $object){

            $items[$object->id] = $object->nome;
        }

        $cidade->addItems($items);
        TTransaction::close();

        // adiciona uma linha para o campo código
        $row = $table->addRow();
        $row->addCell(new TLabel('Código:'));
        $row->addCell('$codigo');

        // adiciona uma linha para o campo nome
        $row = $table->addRow();
        $row->addCell(new TLabel('Nome:'));
        $row->addCell('$nome');

        // adiciona uma linha para o campo endereço
        $row = $table->addRow();
        $row->addCell(new TLabel('Endereço:'));
        $row->addCell('$endereco');
    
        // adiciona uma linha para o campo cidade
        $row = $table->addRow();
        $row->addCell(new TLabel('Cidade:'));
        $row->addCell('$cidade');

        // cria um botão de ação para o formulário
        $button1 = new TButton('action1');

        // define a ação do botão
        $button1->setAction(new TAction(array($this, 'onSave')), 'Salvar');


        // adiciona uma linha para a ação do formulário
        $row = $table->addRow();
        $row->addCell('');
        $row->addCell($button1);

        // define quais são os campos do formulário
        $this->form->setFields(array($codigo, $nome, $endereco, $telefone, $cidade, $button1));

        // adiciona o formulário na página
        parent::add($this->form);
    }

    /**
     * método onEdit()
     * edita os dados de um registro
     */
    function onEdit($param){

        try {

            //inicia transação com o banco 'my_livro'
            TTransaction::open('my_livro');
            
            // obtém o Cliente de acordo com o parâmetro
            $cliente = new clienteRecord($param['key']);

            // lança os dados do cliente no formulário
            $this->form->setData($cliente);

            // finaliza a transação
            TTransaction::close();

        } catch(Exception $e){ // em caso de exceção 

            // exibe a mensagem gerada pela exceção
            new TMessage('error', '<b>Erro</b>'. $e->getMessage());

            // desfaz todas alterações no banco de dados
            TTransaction::rollback();
        }
    }

    
    /**
     * método onSave()
     * executa quando o usuário clicar no botão salvar do formulário
     */
    function onSave(){
        
        try {
            // inicia transação com o banco 'my_livro'
            TTransaction::open('my_livro');

            // lê os dados do formulário e instancia um objeto ClienteRecord
            $cidade = $this->form->getData('ClienteRecord');

            // armazena o objeto
            $cidade->store();

            // finaliza a transação
            TTransaction::close();

            // exibe mensagem de sucesso
            new TMessage('info', 'Dados armazenado com sucesso');

        } catch(Exception $e){ // em caso de exceção

            // exibe a mensagem gerada pela exeção
            new TMessage('error', '<b>Erro</b>'. $e->getMessage());

            // desfaz todas alterações no banco de dados
            TTransaction::rollback();
        }
    }
}