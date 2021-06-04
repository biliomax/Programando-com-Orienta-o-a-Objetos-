<?php
/**
 * função __autoload()
 * Carrega uma classe quando ela é necessária, ou seja, quando ela é instancia pela primeira vez
 * inserir função __autoload() para carregar as classes...
 */
function __autoload($classe){

    if(file_exists("app.ado/{$classe}.class.php")){
        include_once "app.ado/{$classe}.class.php";
    }
}

/**
 * classe Aluno, filha de TRecord
 * persiste um aluno no banco de dados
 */
class AlunoRecord extends TRecord{}

/**
 * classe CursoRecord, filha de TRecord
 * persiste um Curso no banco de dados
 */
class CursoRecord extends TRecord{}

// exclui objetos da base de dados

try {

    // inicia transação com o banco 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log5.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** Apagando da primeira forma");

    // carrega o objeto
    $aluno = new AlunoRecord(1);

    // delete o objeto
    $aluno->delete();

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** Apagando da segunda forma");

    // instancia o modelo
    $modelo = new AlunoRecord;

    // delete o objeto
    $modelo->delete(2);

    // finaliza a transação
    TTransaction::close();

    echo "Exclusão realizada com sucesso <br>\n";
}
catch (Exception $e){ // em caso de exceção
     
    // exibe a mensagem gerada pela execção
    echo '<b>Erro<b>'. $e->getMessage();

    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}