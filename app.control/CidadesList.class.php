<?php
/**
 * classe CidadesList
 * cadastro de cidades: contém o formulário e a listagem
 */
class CidadesList extends TPage {

    private $form;      // formulário de cadastro
    private $datagrid;  // listagem

    /**
     * método construtor
     * Cria a página, o formulário e a listagem
     */
    public function __construct() {
        
        parent::__construct();

        // instancia um formulário
        $this->form = new TForm('form_cidades');

        // instancia uma tabela
        $table = new TTable;

        // adiciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $codigo     = new TEntry('id');
        $descricao  = new TEntry('nome');
        $estado     = new TCombo('estado');

        // cria um vetor com as opções da combo
        $items = array();
        $items['RS'] = 'Rio Grande do Sul';
        $items['SP'] = 'São Paulo';
        $items['MG'] = 'Minas Gerais';
        $items['PR'] = 'Paraná';

        // adiciona as opções na combo
        $estado->addItems($items);

        // define os tamanhos dos campos
        $codigo->setSize(40);
        $estado->setSize(200);

        // adiciona uma linha para o campo código
        $row = $table->addRow();
        $row->addCell(new TLabel('Código'));
        $row->addCell($codigo);

        // adiciona uma linha para o campo descrição
        $row = $table->addRow();
        $row->addCell(new TLabel('Descrição'));
        $row->addCell($descricao);

        // adiciona uma linha para o campo estado
        $row = $table->addRow();
        $row->addCell(new TLabel('Estado'));
        $row->addCell($estado);

        // cria um botão de ação (salvar)
        $salve_button = new TButton('salvar');
        // define a ação do botão
        $salve_button->setAction(new TAction(array($this, 'onSave')), 'Salvar');

        // adiciona uma linha para a ação do formulário
        $row = $table->addRow();
        $row->addCell($salve_button);

        // define quais são os campos do formulário
        $this->form->setFields(array($codigo, $descricao, $estado, $salve_button));

        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;

        // instancia as colunas da DataGrid
        $codigo   = new TDataGridColumn('id',     'Código', 'right',    50);
        $nome     = new TDataGridColumn('nome',   'Nome',   'left',    200);
        $estado   = new TDataGridColumn('estado', 'Estado', 'left',     40);

        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($nome);
        $this->datagrid->addColumn($estado);
    }
}