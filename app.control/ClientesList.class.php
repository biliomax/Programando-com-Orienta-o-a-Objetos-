<?php

/**
 * classe ClientesList
 * listagem de Clientes
 */
class ClientesList extends TPage {

    private $form; // formulário de buscas
    private $datagrid; // listagem
     
    /**
     * método construtor
     * cria a página, o formulário de buscas e a listagem
     */
    public function __construct() {
        
        parent::__construct();

        // instancia um formulário
        $this->form = new TForm('form_busca_clientes');

        // instancia uma tabela
        $table = new TTable;

        // adciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $nome = new TEntry('nome');

        // adiciona uma linha para o campo nome
        $row = $table->addRow();
        $row->addCell(new TLabel('Nome'));
        $row->addCell($nome);

        // cria dois botões de ação para o formulário
        $find_button = new TButton('busca');
        $new_button  = new TButton('cadastra');

        // define as ações dos botões
        $find_button->setAction(new TAction(array($this, 'onReload')), 'Buscar');
        $obj = new ClientesForm;
        $new_button->setAction(new TAction(array($obj, 'onEdit')), 'Cadastrar');

        // adiciona uma linha para as ações do formulário
        $row = $table->addRow();
        $row->addCell($find_button);
        $row->addCell($new_button);

        // define quais são os campos do formulário
        $this->form->setFields(array($nome, $find_button, $new_button));

        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;

        // instancia as colunas da DataGrid
        $codigo     = new TDataGridColumn('id',         'Código',   'right', 50);
        $nome       = new TDataGridColumn('nome',       'Nome',     'right', 140);
        $endereco   = new TDataGridColumn('endereco',   'endereco', 'right', 140);
        $cidade     = new TDataGridColumn('nome_cidade','Cidade',   'right', 140);

        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($endereco);
        $this->datagrid->addColumn($cidade);

        // instancia duas ações da DataGrid
        // $obj = new ClientesForm
        $action1 = new TDataGridAction(array($obj, 'onEdit'));
        $action1->setLabel('Editar');
        $action1->setImage('icon.jpg');
        $action1->setField('id');

        $action2 = new TDataGridAction(array($obj, 'onDelete'));
        $action2->setLabel('Editar');
        $action2->setImage('icon.jpg');
        $action2->setField('id');

        // adiciona as ações à DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);

        // cria o modelo da DataGrid, montado sua estrutura
        $this->datagrid->createModel();

        // monta a página através de uma tabela
        $table = new TTable;
        $table->width = '100%';

        // cria uma linha para o formulário
        $row = $table->addRow();
        $row->addCell($this->form);

        // cria uma linha para a datagrid
        $row = $table->addRow();
        $row->addCell($this->datagrid);

        // adiciona a tabela à página
        parent::add($table);
    }

    /**
     * método onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload(){

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // intancia um repositório para Cliente
        $repository = new TRepository('Cliente');

        // cria um critério de seleção de dados
        $criteria = new TCriteria;
        
        // ordena pelo campo id
        $criteria->setProperty('order', 'id');
        
        // obtém os dados do formulário de buscas
        $dados = $this->form->getData();

        // verifica se o usuário preencheu o formulário
        if($dados->nome){

            // filtra pelo nome do cliente
            $criteria->add(new TFilter('nome', 'like', "%{$dados->nome}%"));
        }

        // carrega os produtos que satisfazem o critério
        $clientes = $repository->load($criteria);
        $this->datagrid->clear();

        if($clientes){

            // percorre os objetos retornados
            foreach($clientes as $cliente){

                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($cliente);
            }
        }

        // finaliza a transação
        TTransaction::close();
        $this->loaded = true;
    }

    /**
     * método onDelete()
     * executada quando o usuário clicar no botão excluir da datagrid
     * pergunta ao usuário se deseja realmente excluir um registro
     */
    function onDelete($param){

        // obtém o parâmetro $key
        $key = $param['key'];

        // define duas ações
        $action1 = new TAction(array($this, 'Delete'));
        $action2 = new TAction(array($this, 'teste'));

        // define os parâmetros de cada ação
        $action1->setParameter('key', $key);
        $action2->setParameter('key', $key);

        // exibe um diálogo ao usuário
        new TQuestion('Deseja relamente excluir o registro?', $action1, $action2);
    }

    /**
     * método Delete()
     * exclui um registro
     */
    function Delete($param){

        // obtém o parâmentro $key
        $key = $param['key'];

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // instancia objeto ClienteRecord
        $cliente = new ClienteRecord($key);

        // deleta objeto do banco de dados
        $cliente->delete();

        // finaliza a transação
        TTransaction::close();

        // recarrega a datagrid
        $this->onReload();

        // exibe mensagwm de sucesso
        new TMessage('info', "Registro excluido com sucesso");
    }

    /**
     * método show()
     * executada quando o usuário clicar no botão excluir
     */
    function show(){

        // se a listagem ainda foi carregada
        if(!$this->loaded){
            
            $this->onReload();
        }
        parent::show();
    }
}