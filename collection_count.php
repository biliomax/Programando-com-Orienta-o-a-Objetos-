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

/* cria as classes Active Record
*  para manipular os registros das tabelas correspondentes
*/

class AlunoRecord extends TRecord {}
class TurmaRecord extends TRecord {}

// conta objetos do banco de dados
try {

    // instancia transação com o banco 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log8.txt'));

    ########################################################
    # primeiro exemplo, conta todos alunos de Porto Alegre #
    ########################################################

    TTransaction::log("** Conta Alunos de Porto Alegre");

    // instancia um critério de seleção
    $criteria = new TCriteria;
    $criteria->add(new TFilter('cidade', '=', 'Porto Alegre'));

    //  instancia um repositório de Alunos
    $repository = new TRepository('Aluno');

    // obtém o total de alunos que satisfazem o critério
    $count = $repository->count($criteria);

    // exibe o total na tela
    echo "Total de alunos de Porto Alegre: {$count} <br>\n";

    ############################################################
    # segundo exemplo, Contar todas turmas com aula na sala    #
    # "100" no turno da Tarde Ou na "200" pelo turno da manhã. #
    ############################################################

    TTransaction::log("** Conta Turmas");

    // instancia um critério de seleção
    // sala "100" e turno "T" (tarde)
    $criteria1 = new TCriteria;
    $criteria1->add(new TFilter('sala', '=', '100'));
    $criteria1->add(new TFilter('turno', '=', 'T'));

    // instancia um critério de seleção
    // sala "200" e turno "M" (manha)
    $criteria2 = new TCriteria;
    $criteria2->add(new TFilter('sala', '=', '200'));
    $criteria2->add(new TFilter('turno', '=', 'M'));

    // instancia um critério de seleção
    // com Ou para juntar os critérios anteriores
    $criteria = new TCriteria;
    $criteria->add($criteria1, TExpression::OR_OPERATOR);
    $criteria->add($criteria2, TExpression::OR_OPERATOR);

    // instancia um repositório de Turmas
    $repository = new TRepository('Turma');

    // retorna quantos objetos satisfazem o critério 
    $count = $repository->count($criteria);
    echo "Total de turmas: {$count} <br>\n";

    // finaliza a transação
    TTransaction::close();

} catch (Exception $e){ // em caso de exceção

    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>' . $e->getMessage();
    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}
