<?php
function getNome($codigo){

    // verifica a passagem do parâmetro
    if(!$codigo) {
        throw new SoapFault('Client', 'Parâmetro não preenchido');
    }

    // conecta ao banco de dados
    $id = @mysqli_connect("localhost", "root", "", "livro");
    
    if(!$id)

        throw new SoapFault("Server", "Conexão não estabelecida");
    

    // realiza consulta ao banco de dados
    $result = mysqli_query($id, "SELECT * FROM pessoa WHERE id = '$codigo'");
    $matriz = mysqli_fetch_all($result);

    if($matriz == null)

        throw new SoapFault("Server", "Cliente não encontrado");
    // retorna os dados
    return $matriz[0];

}

    // instancia servidor SOAP
    $server = new SoapServer("exemplo.wsdl", array('encoding'=>'ISO-8859-1'));
    $server->addFunction("getNome");
    $server->handle();
