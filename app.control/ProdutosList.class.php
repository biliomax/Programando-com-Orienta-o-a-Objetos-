<?php
/**
 * classe ProdutosList
 * listagem de produtos
 */
class ProdutosList extends TPage {

    private $form;  // formulário de buscas
    private $datagrid; // listagem

    /**
     * método construtor
     * Cria a página, o formulário de buscas e a listagem
     */

     public function __construct()
     {
        parent::__construct();

        // instancia um formulário
        $this->form = new TForm('form_busca_produtos');

        // instancia uma tabela
        $table = new TTable;

        // adiciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $descricao = new TEntry('descricao');

        // adiciona uma linha para o campo descrição
        $row = $table->addRow();
        $row->addCell(new TLabel('Descrição:'));
        $row->addCell($descricao);

        // cria dois botões de ação para o formulário
        $find_button = new TButton('buscar');
        $new_button  = new TButton('cadastrar');

        // define as ações dos botões
        $find_button->setAction(new TAction(array($obj, 'onEdit')), 'Buscar');

        $obj = new ProdutosForm;
        $new_button->setAction(new TAction(array($obj, 'onEdit')), 'Cadastrar');

        // adiciona uma linha para as ações do formulário
        $row = $table->addRow();
        $row->addCell($find_button);
        $row->addCell($new_button);

        // define quais são os campos do formulário
        $this->form->setFields(array($descricao, $find_button, $new_button));

        // instancia objeto DataGrid
        $this->datagrid = new TDataGrid;

        // instancia as colunas da DataGrid
        $codigo    = new TDataGridColumn('id',          'Código',          'right',  50);
        $descricao = new TDataGridColumn('descricao',   'Descrição',       'left',  270);
        $fabrica   = new TDataGridColumn('fabrica',     'nome_fabricante', 'left',   80);
        $estoque   = new TDataGridColumn('estoque',     'Estoq',            'right', 40);
        $preco     = new TDataGridColumn('preco_venda', 'Venda',            'right', 40);

        // adiciona as colunas à DataGrid
        $this->datagrid->addColumn($codigo);
        $this->datagrid->addColumn($descricao);
        $this->datagrid->addColumn($fabrica);
        $this->datagrid->addColumn($estoque);
        $this->datagrid->addColumn($preco);

        // instancia duas ações da DataGrid
        $obj = new ProdutosForm;
        $action1 = new TDataGridAction(array($obj, 'onEdit'));
        $action1->setLabel('Editar');
        $action1->setImage('ico_edit.png');
        $action1->setField('id');

        $action2 = new TDataGridAction(array($this, 'onDelete'));
        $action1->setLabel('Deletar');
        $action1->setImage('icon.jpg');
        $action1->setField('id');

        // adiciona as ações à DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);

        // cria o modelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();

     }

    /**
     * método onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload(){

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // intancia um repositório para Produto
        $repository = new TRepository('Produto');

        // cria um critério de seleção, ordenado pelo id
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'id');

        // obtém os dados do formulário de busca
        $dados = $this->form->getData();
        
        // verifica se o usuário preencheu o formulário
        if($dados->descricao){

            // filtra pela descrição do peoduto
            $criteria->add(new TFilter('descricao', 'like', "%{$dados->descricao}%"));
        }
        
        // carrega os objetos de acordo com o critério
        $produtos = $repository->load($criteria);
        $this->datagrid->clear();

        if($produtos){

            // percorre os objetos retornados
            foreach($produtos as $produto){

                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($produto);
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
        new TQuestion('Deseja realmente excluir o registro?', $action1, $action2);
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

        // instancia objeto ProdutoRecord
        $produto = new ProdutoRecord($key);

        // deleta objeto do banco de dados
        $produto->delete();

        // finaliza a transação
        TTransaction::close();

        // recarrega a datagrid
        $this->onReload();

        // exibe mensagwm de sucesso
        new TMessage('info', "Registro excluido com sucesso");
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