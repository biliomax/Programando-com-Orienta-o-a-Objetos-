<?php
function __autoload($classe){

    if(file_exists("app.widgets/{$classe}.class.php")){
        include_once "app.widgets/{$classe}.class.php";
    }
}

/**
 * método onProdutos()
 * executado quando o usuário clicar no link "Produtos"
 * @param $get = variável $_GET
 */
function onProdutos($get){
    echo "Nesta seção você vai conhecer os produtos da nossa empresa...";
}

/**
 * método onContrato()
 * executado quando o usuário clicar no link "Contato"
 * @param $get = variável $_GET
 */
function onContato($get){
    echo "Para entrar em contato com nossa empresa...";
}

/**
 * método onEmpresa()
 * executado quando o usuário clicar no link "Empresa"
 * @param $get = variável $_GET
 */
function onEmpresa($get){
    echo "Aqui na fazenda recanto escondido fazemos eco-turismo...";
}

// exibe alguns links
echo "<a href='?method=onProdutos&class'>Produtos</a><br>";
echo "<a href='?method=onContato&class'>Contato</a><br>";
echo "<a href='?method=onEmpresa&class'>Empresa</a><br>";

// interpreta a página
$pagina = new TPage;
$pagina->show();