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

/* classe AlunoRecord, filha de TRecord
 * persistem um Aluno no banco de dados
 */
class AlunoRecord extends TRecord {}

/**
 * classe CursoRecord, filha de TRecord
 * persiste um curso no banco de dados
 */

 class CursoRecord extends TRecord {}

 // instancia objeto Aluno
 $fabio = new AlunoRecord;

 // define algumas propriedades
 $fabio->nome       = 'Fabio Locatelli';
 $fabio->endereco   = 'Rua Merlin';
 $fabio->telefone   = '(51) 2222-1111';
 $fabio->cidade     = 'Lajeado';

 // clona o objeto $fabio
 $julia = clone $fabio;

 // altera algumas propriedades
 $julia->nome       = 'Júlia Haubert';
 $julia->telefone   = '(51) 2222-2222';

 try {
    // instancia transação com o banco 'my_livro'
    TTransaction::open('my_livro');
    
    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log4.txt'));

    // armazena o objeto $fabio
    TTransaction::log("** persistindo o curso \$fabio");
    $fabio->store();

    // armazena o objeto $julia
    TTransaction::log("** persistindo o curso \$julia");
    $julia->store();

    // finaliza a transação
    TTransaction::close();

    echo "Clonagem realizada com sucesso <br>\n";

 } catch(Exception $e){ // em caso de exceção
    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>' . $e->getMessage();

    // desfaz todas alteração no banco de dados
    TTransaction::rollback();
 }
