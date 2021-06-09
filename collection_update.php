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
 * cria as classes Active Record
 * para manipular os registros das tabelas correspondentes
 */
class InscricaoRecord extends TRecord {}

// obtém objetos do banco de dados
try {
    
    // inicia transação com o banco 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log7.txt'));
    TTransaction::log("** seleciona inscrições da turma 2");

    // instancia critério de seleção de dados
    // seleciona todas inscrições da turma "2"
    $criteria = new TCriteria;
    $criteria->add(new TFilter('ref_turma', '=', 2));
    $criteria->add(new TFilter('cancelada', '=', FALSE));

    // instancia repositório de Inscrição
    $repository = new TRepository('Inscricao');

    // retorna todos objetos que satisfazem o critério
    $inscricoes = $repository->load($criteria);

    // verifica se retornou alguma inscrição
    if($inscricoes){
        TTransaction::log("** altera as inscrições");

        // percorre todas inscrições retornadas
        foreach($inscricoes as $inscricao){

            // altera algumas propriedades
            $inscricao->nota        = 8;
            $inscricao->frequencia  = 75;

            // armazena o objeto no banco de dados
            $inscricao->store();
        }
    }

    // finaliza a transação
    TTransaction::close();

} catch(Exception $e){ // em caso de exceção

    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>'. $e->getMessage();

    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}
