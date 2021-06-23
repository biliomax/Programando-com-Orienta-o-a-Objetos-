<?php

use PessoaList as GlobalPessoaList;
use PessoaRecord as GlobalPessoaRecord;

/**
 * função __autoload()
 * carrega uma classe quando ela é necessária,
 * ou seja, quando ela é instancia pela primeira vez.
 */
function __autoload($classe){

    $pastas = array('app.widgets', 'app.ado');
    foreach($pastas as $pasta){

        if(file_exists("{$pasta}/{$classe}.class.php")){

            include_once "{$pasta}/{$classe}.class.php";
        }
    }
}

// declara a classe PessoaRecord
class PessoaRecord extends TRecord {}

/**
 * classe PessoaList
 */
class PessoaList extends TPage {
    
    private $datagrid;

    public function __construct(){
        
        parent::__construct();

        // instancia obejto DataGrid
        $this->datagrid = new TDataGrid;

        // instancia as colunas da DataGrid
        $codigo     = new TDataGridColumn('id',         'Código',        'left',     50);
        $nome       = new TDataGridColumn('nome',       'Nome',          'left',    180);
        $endereco   = new TDataGridColumn('endereco',   'Endereço',      'left',    140);
        $qualifica  = new TDataGridColumn('qualifica',  'Qualificações', 'left',    200);

        // adiciona as colunas à DataGrid
        $this->datagrid->addColum($codigo);
        $this->datagrid->addColum($nome);
        $this->datagrid->addColum($endereco);
        $this->datagrid->addColum($qualifica);

        // instancia duas ações da DataGrid
        $action1 = new TDataGridAction(array($this, 'onDelete'));
        $action1->setLabel('Deletar');
        $action1->setImage('icon.jpg');
        $action1->setField('id');

        $action2 = new TDataGridAction(array($this, 'onView'));
        $action2->setLabel('Visualizar');
        $action2->setImage('icon.jpg');
        $action2->setField('id');

        // adiciona as ações à DataGrid
        $this->datagrid->addAction($action1);
        $this->datagrid->addAction($action2);

        // cria o medelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();

        // adiciona a DataGrid à página
        parent::add($this->datagrid);
    }

    /**
     * função onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload(){

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // instancia um repositório para Pessoa
        $repository = new TRepository('Pessoa');

        // cria um critério, definindo a ordenação
        $criteria = new TCriteria;
        $criteria->setProperty('order', 'id');

        // carrega os objetos $pessoas
        $pessoas = $repository->load($criteria);
        $this->datagrid->clear();

        if($pessoas){

            foreach($pessoas as $pessoa){

                // adiciona o objeto na DataGrid
                $this->datagrid->addItem($pessoa);
            }
        }

        // finaliza a transação
        TTransaction::close();
        $this->loaded = true;
    }

    /**
     * função onDelete()
     * executada quando o usuário clicar no botão excluir
     */
    function onDelete($param){

        // obtém o parâmetro e exibe mensagem
        $key = $param['key'];

        $action1 = new TAction(array($this, 'Delete'));
        $action2 = new TAction(array($this, 'teste'));

        $action1->setParameter('key', $key);
        $action2->setParameter('key', $key);

        new TQuestion('Deseja realmente excluir o registro?', $action1, $action2);
    }

    /**
     * função Delete()
     * excluir um registro
     */
    function Delete($param){

        // obtém o parâmetro e exibe mensagem
        $key = $param['key'];

        // incia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        $pessoa = new PessoaRecord($key);
        $pessoa->delete();

        // finaliza a transação
        TTransaction::close();
        new TMessage('info', "Registro excluido com sucesso");
        $this->onReload();
    }

    /**
     * função onView()
     * Executada quando o usuário clicar no botão visualizar
     */
    function onView($param){

        // obtém o parâmetro e exibe mensagem
        $key = $param['key'];

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        $pessoa = new PessoaRecord($key);

        // finaliza a transação
        TTransaction::close();
        $mensagem = "O nome é: $pessoa->nome<br>";
        $mensagem.= "O Endereço é $pessoa->endereco";
        new TMessage('info', $mensagem);
        $this->onReload();
    }

    /**
     * função show()
     * executada quando o usuário clicar no botão excluir
     */
    function show(){

        if(!$this->loaded){
            
            $this->onReload();
        }

        parent::show();
    }
}

$page = new PessoaList;
$page->show();