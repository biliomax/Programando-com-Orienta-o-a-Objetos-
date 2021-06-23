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
        $telefone  = new TDataGridColumn('telefone',    'Telefone',      'left',    200);

        $action1 = new TAction(array($this, 'onReload'));
        $action1->setParameter('order', 'id');

        $action2 = new TAction(array($this, 'onReload'));
        $action2->setParameter('order', 'nome');
        $codigo->setAction($action1);
        $nome->setAction($action2);

        // adiciona as colunas à DataGrid
        $this->datagrid->addColum($codigo);
        $this->datagrid->addColum($nome);
        $this->datagrid->addColum($endereco);
        $this->datagrid->addColum($telefone);

        // cria o medelo da DataGrid, montando sua estrutura
        $this->datagrid->createModel();

        // adiciona a DataGrid à página
        parent::add($this->datagrid);
    }

    /**
     * função onReload()
     * carrega a DataGrid com os objetos do banco de dados
     */
    function onReload($param = NULL){

        $order = $param['order'];

        // inicia transação com o banco 'my_livro'
        TTransaction::open('my_livro');

        // instancia um repositório para Pessoa
        $repository = new TRepository('Pessoa');

        // retorna todos objetos que satisfazem o critério
        $criteria = new TCriteria;
        $criteria->setProperty('order', $order);
        $pessoas = $repository->load($criteria);

        if($pessoas){

            $this->datagrid->clear();
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