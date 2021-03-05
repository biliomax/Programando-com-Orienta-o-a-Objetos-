<?php
/**
 * classe TConnection
 * gerencia conexões com bancos de dados através de arquivos de configuração.
 */
final class TConnection {
    /**
     * Método __construct()
     * não existirão instâncias de TConnection, por isto estamos marcando-o como private
     */
    private function __construct(){}

    /**
     * Método open()
     * recebe o nome do banco de dados e instancia o objeto PDO correspondente
     */
    public static function open($name){

        // Verifica se existe arquivo de configuração para este banco de dados
        if(file_exists("app.config/{$name}.ini")){
            
            // lê o INI e retorna um array
            $db = parse_ini_file("app.config/{$name}.ini");
        } else {
            // se não existir, lança um erro
            throw new Exception("Arquivo '$name' não econtrado");
        }

        // Lê as informações contidas no arquivo
        $user = $db['user'];
        $pass = $db['pass'];
        $name = $db['name'];
        $host = $db['host'];
        $type = $db['type'];

        // descobre qual o tipo (drive) de banco de dados a ser utilizado
        switch($type){
            case 'pgsql':
                $conn = new PDO("pgsql:dbname={$name};user={$user}; password={$pass};host=$host");
                break;
            case 'mysql':
                $conn = new PDO("mysql:host={$host};dbname={$name}", $user, $pass);
                #$conn = new PDO('mysql:host=localhost;dbname=livro','root','');
                break;
            case 'sqlite':
                $con = new PDO("sqlite:{$name}");
                break;
            case 'ibase':
                $conn = new PDO("firebird:dbname={$name}", $user, $pass);
                break;
            case 'oci8':
                $conn = new PDO("oci:dbname={$name}", $user, $pass);
                break;
            case 'mssql':
                $conn = new PDO("mssql:host={$host},1433;dbname={$name}", $user, $pass);
                break;
        }

        // Define para que o PDO lance exceções na ocorrência de erros
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);

        // retorna o objeto instanciado.
        return $conn;
    }

}