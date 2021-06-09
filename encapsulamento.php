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
 * classe TurmaRecord, filha de TRecord
 * persiste um Aluno no banco de dados
 */
class TurmaRecord extends TRecord{
    /**
     * método set_dia_semana()
     * executado sempre que há ua atribuição para "dia_semana"
     * @param $valor = valor atribuido
     */
    function set_dia_semana($valor){

        // verifica se o dia da semana está entre 1 e 7 e é um número
        if(is_int($valor) and ($valor >= 1) and ($valor <= 7)){

            // atribui o valor à propriedade
            $this->data['dia_semana'] = $valor;
        } else {
            // exibe mensagem de erro
            echo "Tentou atribuir '{$valor}' em dia_semana <br>\n";
        }
    }

    /**
     * método set_turno()
     * executado sempre que há uma atribuição para "turno" 
     * @param $valor = valor atribuido
     */
    function set_turno($valor){

        // verifica se o valor é 'M', 'T', ou 'N'
        if(($valor == 'M') or ($valor == 'T') or ($valor == 'N')){
            // atribui o valor á propriedade
            $this->data['turno'] = $valor;

        } else {
            // exibe mensagem de erro
            echo "Tentou atribuir '{$valor}' em turno <br>\n";
        }
    }
}

// insere novos objetos no banco de dados
try{

    // instancia transação com o banco de dados 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log10.txt'));

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo turma 1");

    // instancia um novo objeto Turma
    $turma = new TurmaRecord;
    $turma->dia_semana  = 1;
    $turma->turno       = 'M';
    $turma->professor   = 'Carlos Gellini';
    $turma->sala        = '100';
    $turma->data_inicio = '2002-09-01';
    $turma->encerrada   = FALSE;
    $turma->ref_curso   = 2;

    $turma->store(); // armazena o objeto

    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo turma 2");

    $turma = new TurmaRecord;
    $turma->dia_semana  = 'Segunda';
    $turma->turno       = 'Manhã';
    $turma->professor   = 'Sérgio Crespo';
    $turma->sala        = '200';
    $turma->data_inicio = '2004-09-01';
    $turma->encerrada   = FALSE;
    $turma->ref_curso   = 3;

    $turma->store(); // armazena o objeto

    // finaliza a transação
    TTransaction::close();

    echo "Registros inseridos com Sucesso<br>\n";
}
catch (Exception $e){ // em caso de exceção

    // exibe mensagem gerad pela exceção
    echo '<b>Erro</b> '.$e->getMessage();

    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
}