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
 * classe AlunoRecord, filha de TRecord
 * persiste um Aluno no banco de dados
 */
class AlunoRecord extends TRecord {}

/**
 * classe CursoRecord, filha de TRecord
 * persiste um Curso no banco de dados
 */
class CursoRecord extends TRecord {}

// obtém objetos do banco de dados
try {
    // incia transação com o banco 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log2.txt'));

    // exibe algumas mensagens na tela
    echo "obtendo aluno <br>\n";
    echo "==============<br>\n";

    // obtém o aluno de ID 1
    $aluno = new AlunoRecord(1);
    echo 'Nome      :'. $aluno->nome        . "<br>\n";
    echo 'Endereço  :'. $aluno->endereco    . "<br>\n";

    // obtém o aluno de ID 2
    $aluno = new AlunoRecord(2);
    echo 'Nome      :'. $aluno->nome        . "<br>\n";
    echo 'Endereço  :'. $aluno->endereco    . "<br>\n";

    // obtém alguns cursos;
    echo '<br>';
    echo "obtendo cursos <br>\n";
    echo "==============<br>\n";

    // obtém o curso de ID 1
    $curso = new CursoRecord(1);
    echo 'Curso :' . $curso->descricao . "<br>\n";

    // obtém o curso de ID 2
    $curso = new CursoRecord(2);
    echo 'Curso :' . $curso->descricao . "<br>\n";

    // finaliza a transação
    TTransaction::close();

} catch (Exception $e) // em caso de exceção
{    
    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>' . $e->getMessage();

    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}