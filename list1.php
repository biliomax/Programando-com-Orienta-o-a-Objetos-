<?php
/**
 * função __autoload()
 * carrega uma classe quando ela é necessária,
 * ou seja, quando ela é instancia pela primeira vez.
 */
function __autoload($classe){

    if(file_exists("app.widgets/{$classe}.class.php")){

        include_once "app.widgets/{$classe}.class.php";
    }
}

// instancia objeto TDataGrid
$datagrid = new TDataGrid;

// instancia as colunas da DataGrid
$codigo     = new TDataGridColumn('codigo',     'Código',   'left',   50);
$nome       = new TDataGridColumn('nome',       'Nome',     'left',   180);
$endereco   = new TDataGridColumn('endereco',   'Endereço', 'left',   140);
$telefone   = new TDataGridColumn('telefone',   'Telefone', 'center', 100);

// adiciona as colunas à DataGrid
$datagrid->addColum($codigo);
$datagrid->addColum($nome);
$datagrid->addColum($endereco);
$datagrid->addColum($telefone);

// instancia duas ações da DataGrid
$action1 = new TDataGridAction('onDelete');
$action1->setLabel('Deletar');
$action1->setImage('ico_delete.png');
$action1->setField('codigo');

$action2 = new TDataGridAction('onView');
$action2->setLabel('Visualizar');
$action2->setImage('ico_view_.png');
$action2->setField('nome');

// adiciona as ações à DataGrid
$datagrid->addAction($action1);
$datagrid->addAction($action2);

// cria o modelo da DataGrid, montando sua estrutura
$datagrid->createModel();

// adiciona um objeto padrão à DataGrid
$item = new stdClass;
$item->codigo       = '1';
$item->nome         = 'Daline DallOglio';
$item->endereco     = 'Rua Conceição';
$item->fone         = '1111-1111';
$datagrid->addItem($item);

// adiciona um objeto padrão à DatGrid
$item = new stdClass;
$item->codigo       = '2';
$item->nome         = 'Willian Scatola';
$item->endereco     = 'Rua Conceição';
$item->fone         = '2222-2222';
$datagrid->addItem($item);

// adiciona um objeto padrão à DatGrid
$item = new stdClass;
$item->codigo       = '3';
$item->nome         = 'Sâmara Petter';
$item->endereco     = 'Rua OliveiraConceição';
$item->fone         = '3333-3333';
$datagrid->addItem($item);

// adiciona um objeto padrão à DatGrid
$item = new stdClass;
$item->codigo       = '4';
$item->nome         = 'Ana Amélia Petter';
$item->endereco     = 'Rua OliveiraConceição';
$item->fone         = '4444-4444';
$datagrid->addItem($item);

// instancia uma página Tpage
$page = new TPage;

// adiciona a DataGrid à página
$page->add($datagrid);

// exibe a página
$page->show();

/**
 * funão onDelete()
 * executada quando o usuário clicar no botão excluir
 */
function onDelete($param){

    // obtém o parmâmetro e exibe mensagem
    $key = $param['key'];
    new TMessage('error', "O registro $key <br> não pode ser excluído");
}

/**
 * função onView()
 * Exceutada quando o usuário clicar no botão visualizar
 */
function onView($param){
    
    // obtém o parâmetro e exibe mensagem
    $key = $param['key'];
    new TMessage('info', "O nome é: <br> $key");
}
