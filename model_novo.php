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

 class AlunoRecord extends TRecord{}

 /**
  * classe CursoRecord, filha de TRecord
  * persiste um Curso no banco de dados
  */
  class CursoRecord extends TRecord {}

  // insere novos objetos no banco de dados
  try {

    // inicia transação com o banco 'my_livro'
    TTransaction::open('my_livro');

    // define o arquivo para LOG
    TTransaction::setLogger(new TLoggerTXT('tmp/log1.txt'));
    
    // armazena esta frase no arquivo de LOG
    TTransaction::log("** inserindo alunos");

    // instancia um novo objeto Aluno
    $daline = new AlunoRecord;
    $daline->nome       = 'Daline Dall Oglio';
    $daline->endereco   = 'Rua da Conceição';
    $daline->telefone   = '(51) 1111-2222';
    $daline->cidade     = 'Cruzeiro do Sul';
    $daline->store();   // armazena o objeto

    // instancia um novo objeto Aluno
    $william = new AlunoRecord;
    $william->nome      = "William Scatolla";
    $william->endereco  = 'Rua da Fátima';
    $william->telefone  = '(51) 1111-4444';
    $william->cidade    = 'Encantado';
    $william->store();  // armazena o objeto

    // armazena esta frase no arquivo de LOG
    TTransaction::log('** inserindo cursos');

    // instancia um novo objeto Curso
    $curso = new CursoRecord;
    $curso->descricao   = 'Orientação a Objetos com PHP';
    $curso->duracao     = 24;
    $curso->store();     // armazena o objeto

    // instancia um novo objeto Curso
    $curso = new CursoRecord;
    $curso->descricao   = 'Desenvolvendo em PHP-GTK';
    $curso->duracao     = 32;
    $curso->store();    // armazena o objeto

    // finaliza a transação
    TTransaction::close();
    echo "Registros inseridos com Sucesso<br>\n";

  } catch(Exception $e) // em caso de exceção
  {

    // exibe a mensagem gerada pela exceção
    echo '<b>Erro</b>'. $e->getMessage();

    // desfaz todas alterações no banco de dados
    TTransaction::rollback();
  }