<?php
// exibe início da tabela
echo '<table border=1>
    <tr bgcolor="#c0c0c0">
        <td></td>
        <td width="70">Código</td>
        <td width="140">Nome</td>
        <td width="140">Endereço</td>
        <td width="100">Telefone</td>
    </tr>';

// abre conexão com Mysql
$conn = mysqli_connect("localhost", "root", "", "livro");

// define consulta que será realizada 
$query = 'SELECT id, nome, endereco, telefone FROM aluno limit 4';
// envia consulta ao banco de dados
$result = mysqli_query($conn, $query);


if($result){

    // percorre resultados da pesquisa
    while($row = mysqli_fetch_assoc($result)){
        $id         = $row['id'];
        $nome       = $row['nome'];
        $endereco   = $row['endereco'];
        $telefone   = $row['telefone'];

        // exibe uma linha de resultados
        echo "<tr>
            <td><a href='edit.php?id={$id}'><img border=0 src='app.images/icon.jpg'></a></td>
            <td align='left'>{$id}</td>
            <td align='left'>{$nome}</td>
            <td align='left'>{$endereco}</td>
            <td align='center'>{$telefone}</td>
        </tr>";
    }
}

// fecha a conexão
mysqli_close($conn);

// imprime fechamento da tabela
echo '</table>';