<?php

try {
    
    // instancia objeto PDO conectando no MySql
    $conn = new PDO('mysql:host=localhost;dbname=livro;','root',''); // Primeira forma de conexção
    #$conn = new PDO('mysql:host=localhost;port=3306;dbname=livro;','root',''); // Segunda forma de conexção

    // executa uma instrução SQL de consulta
    $result = $conn->query("SELECT codigo, nome FROM famosos");
    if($result){

        // percorre os resultados via fetch()
        while($row = $result->fetch(PDO::FETCH_OBJ)){

            // exibe os dados na tela, acessando o objeto retornado
            echo $row->codigo . ' - ' . $row->nome . "<br/>";
        }
    }

    // fecha conexão
    $conn = null;
}
catch (PDOException $e) {
    //throw $e;
    print "Erro!: ".$e->getMessage()."<br/>";
    die();
}