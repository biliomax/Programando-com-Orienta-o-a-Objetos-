<?php

use AlunoRecord as GlobalAlunoRecord;
use CursoRecord as GlobalCursoRecord;

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
 * classe AlunoRecord, filha dde TRecord
 * persiste um Aluno no banco de dados
 */
class AlunoRecord extends TRecord{}

/**
 * classe CursoRecord, filha de TRecord
 * persiste um Curso no banco de dados
 */
class CursoRecord extends TRecord{}

// altera objetos no banco de dados
try {
    // inicia transação com o banco 'my_livro'
    TTransaction::open('my_livro');
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log3.txt'));

    TTransaction::log("** obtendo o aluno 1");
    // instancia registro de Aluno
    $record = new AlunoRecord();
    // obtém um Aluno de ID 1
    $aluno = $record->load(1);

    if($aluno) // verifica se ele existe
    {
        // altera o telefone
        $aluno->telefone = '(51) 1111-3333';
        TTransaction::log("** persistindo o aluno 1");

        // armazena o objeto
        $aluno->store();
    }

    TTransaction::log("** obtendo o curso 1");
    // instancia registro de Curso
    $record = new CursoRecord;
    // obtém o Curso de ID 1
    $curso = $record->load(1);
    
    if($curso) // verifica se ele existe
    {
        // altera a educação
        $curso->duracao = 28;
        TTransaction::log("** presistindo o curso 1");
        // armazena o objeto
        $curso->store();
    }

    // finaliza a transação
    TTransaction::close();
    // exibe mensagem de sucesso
    echo "Registros alterados com sucesso<br>\n";

} catch(Exception $e){ // em caso de exceção
    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>'. $e->getMessage();
    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}
