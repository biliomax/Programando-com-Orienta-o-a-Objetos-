<?php

// abre conexão com o MySql
#$conn = new mysqli('localhost', 'root', '', 'livro'); // primeira forma de se conectar
#$conn = mysqli_connect('localhost', 'root', '', 'livro'); // segunda forma de se conectar
$conn = mysqli_connect('localhost', 'root', ''); // terçeira forma de se conectar

mysqli_select_db($conn, 'livro'); // outra forma de selecionar o banco de dados

// define consulta que será realizada
$query = 'SELECT codigo, nome FROM famosos';

// envia consulta ao banco de dados
$result = mysqli_query($conn, $query);

if($result){

    // pecorre resultados da pesquisa
    while($row = mysqli_fetch_assoc($result)){
        echo $row['codigo'] . ' - '. $row['nome']. "<br>\n";
    }
}

// fecha a conexão
mysqli_close($conn);