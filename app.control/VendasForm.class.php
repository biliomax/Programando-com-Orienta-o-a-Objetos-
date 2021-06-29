<?php
/**
 * função formata_string
 * exibeum valor com as casas decimais
 */
function formata_money($valor){

    return number_format($valor, 2, ',', '.');
}

/**
 * classe VendasForm
 * formulário de vendas
 */
class VendasForm extends TPage {

    private $form;      // formulário de novo item
    private $datagrid;  // listagem de itens

    /**
     * método construtor
     * cria a página e o formulário de cadastro
     */
    public function __construct()
    {
        parent::__construct();
        // instancia nova seção
        new TSession;

        // instancia um formulário
        $this->form = new TForm('form_vendas');

        // instancia uma tabela
        $table = new TTable;

        // adiciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $codigo     = new TEntry('id_produto');
        $quantidade = new TEntry('quantidade');

        // define os tamanhos
        $codigo->setSize(100);

        // adiciona uma linha para o campo código
        $row = $table->addRow();
        $row->addCell(new TLabel('Código:'));
        $row->addCell($codigo);

        // adiciona uma linha para o campo quantidade
        $row = $table->addRow();
        $row->addCell(new TLabel('Quantidade:'));
        $row->addCell($quantidade);
        
        // cria dois botões de ação para o formulário
        $save_button = new TButton('save');
        $fim_button  = new TButton('fim');

        // define as ações dos botões

        $save_button->setAction(new TAction(array($this, 'onAdiciona')), 'Adicionar');
        $fim_button->setAction(new TAction(array($this, 'onFinal')), 'Finalizar');

        // adiciona uma linha para as ações do formulário
        $row = $table->addRow();
        $row->addCell($save_button);
        $row->addCell($fim_button);

        // define quais são os campos do formulário
        $this->form->setFields(array($codigo, $quantidade, $save_button, $fim_button));

        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;

        // instancia as colunas da Datagrid
        $codigo       = new TDataGridColumn('id_produto', 'Código',    'right', 50);
        $descricao    = new TDataGridColumn('descricao',  'Descrição', 'left', 200);
        $quantidade   = new TDataGridColumn('quantidade', 'Descrição', 'right', 40);
        $preco        = new TDataGridColumn('preco_venda','Preço',     'right', 70);

        // define um transformador para a coluna preço
        $preco->setTransformer('formata_money');

        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($descricao);
        $this->datagrid->addColumn($quantidade);
        $this->datagrid->addColumn($preco);

        // cria uma ação para a datagrid
        $action = new TDataGridAction(array($this, 'onDelete'));
        $action->setLabel('Deletar');
        $action->setImage('icon.jpg');
        $action->setField('id_produto');

        // adiciona a ação à DataGrid
        $this->datagrid->addAction($action);

        // cria o modelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();

        // monta a página através de uma tabela
        $table = new TTable;

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
     * método onAdiciona()
     * executada quando o usuário clicar no botão salvar do formulário
     */
    function onAdiciona(){

        // obtém os dados do formulário
        $item = $this->form->getData('ItemRecord');

        // lê variável $list da seção
        $list = TSession::getValue('list');

        // acrescenta produto na variável $list
        $list[$this->id_produto] = $item;

        // grava variável $list de volta à seção
        TSession::setValue('list', $list);

        // recarrega a listagem
        $this->onReload;
    }
}