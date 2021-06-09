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

/** cria classes Active Record para manipular os registros das tabelas correspondentes */
class TurmaRecord   extends TRecord{}
class InscricaoRecord   extends TRecord{}

// deleta objetos do banco de dados
try {

    // inicia transação com o banco 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log9.txt'));

    ##################################################
    # primeiro exemplo, exclui todas turmas da tarde #
    ##################################################

    TTransaction::log("** exclui as turmas da tarde");

    // instancia um critério de seleção de turno = 'T'
    $criteria = new TCriteria;
    $criteria->add(new TFilter('turno', '=', 'T'));

    // instancia repositório de Turmas
    $repository = new TRepository('Turma');

    // retorna todos objetos que satisfazem o critério
    $turmas = $repository->load($criteria);

    // verifica se retornou alguma turma
    if($turmas){

        // percorre todas turmas retornadas
        foreach($turmas as $turma){

            // exclui a turma
            $turma->delete();
        }
    }

    ############################################################
    # segundo exemplo, exclui todas as inscrições do aluno "1" #
    ############################################################

    TTransaction::log("** exclui as inscrições do aluno '1'");

    // instancia critério de seleção de dados ref_aluno = '1'
    $criteria = new TCriteria;
    $criteria->add(new TFilter('ref_aluno', '=', 1));

    // instncia repositório de Inscrição
    $repository = new TRepository('inscricao');

    // exclui todos objetos que satisfaçam este critério de seleção
    $repository->delete($criteria);

    echo "registros excluídos com sucesso <br>\n";
    // finaliza a transação
    TTransaction::close();
}
catch(Exception $e){ // em caso de exceção

    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>'. $e->getMessage();

    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}