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

        // instancia duas ações da DataGrid
        $action1 = new TDataGridAction(array($this, 'onEdit'));
        $action1->setLabel('Editar');
        $action1->setImage('icon.jpg');
        $action1->setField('id');

        $action2 = new TDataGridAction(array($this, 'onDelete'));
        $action2->setLabel('Deletar');
        $action2->setImage('icon.jpg');
        $action2->setField('id');

        // adiciona as ações à DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);

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
     * método onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload(){

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // intancia um repositório para Cidade
        $repository = new TRepository('Cidade');

        // cria um critério de seleção, ordenado pelo id
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'id');

        // carrega os objetos de acordo com o critério
        $cidades = $repository->load($criteria);
        $this->datagrid->clear();

        if($cidades){

            // percorre os objetos retornados
            foreach($cidades as $cidade){

                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($cidade);
            }
        }

        // finaliza a transação
        TTransaction::close();
        $this->loaded = true;
    }

    /**
     * método onSave()
     * executa quando o usuário clicar no botão salvar do formulário
     */
    function onSave(){

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // obtém os dados no formulário em um objeto CidadeRecord
        $cidade = $this->form->getData('CidadeRecord');

        // armazena o objeto
        $cidade->store();

        // finaliza a transação
        TTransaction::close();

        // exibe mensagem de sucesso
        new TMessage('info', 'Dados armazenado com sucesso');

        // recarrega listagem
        $this->onReload();
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

        // instancia objeto CidaadeRecord
        $cidade = new CidadeRecord($key);

        // deleta objeto do banco de dados
        $cidade->delete();

        // finaliza a transação
        TTransaction::close();

        // recarrega a datagrid
        $this->onReload();

        // exibe mensagwm de sucesso
        new TMessage('info', "Registro excluido com sucesso");
    }

    /**
     * método onEdit()
     * executada quando o usuário clicar no botão esitar da datagrid
     */
    function onEdit($param){

        // obtém o parâmetro $key
        $key = $param['key'];

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // instancia objeto CidadeRecord
        $cidade = new CidadeRecord($key);

        // lança os dados da cidade no formulário
        $this->form->setData($cidade);

        // finaliza a transação
        TTransaction::close();
        $this->onReload();
    }

    /**
     * método show()
     * exibe a página
     */
    function show(){

        // se a listagem ainda foi carregada
        if(!$this->loaded){
            $this->onReload();
        }
        parent::show();
    }
}