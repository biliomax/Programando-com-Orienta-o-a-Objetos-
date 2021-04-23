<?php
/**
 * classe ProdutoGateway
 * implemnta Table Data
 */
class ProdutoGateway {

    /**
     * método insert
     * insere dados na tabela de Produtos
     * @param $object = objeto a ser inserido
     */
    function insert(Produto $object){

        // Cria instrução SQL de insert
        $sql = "INSERT INTO Produtos (id, descricao, estoque, preco_custo)".
                " VALUES ('$object->id', '$object->descricao', ".
                "'$object->estoque', '$object->preco_custo')";

        // Instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
    }

    /**
     * método update
     * altera os dados na tabela de Produtos
     * @param $object = objeto a ser alterado
     */
    function update(Produto $object) {

        // cria instrução SQL de UPDATE
        $sql = "UPDATE produtos set ".
               "  descricao    = '$object->descricao',".
               "  estoque      = '$object->estoque',".
               "  preco_custo  = '$object->preco_custo'".
               "  WHERE id     = '$object->id'";

        // Instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $conn->exec($sql);
        unset($conn);
    }

    /**
     * método getObject
     * busca um registro da tabela de produtos
     * @param $id = ID do produto
     */
    function getObject($id){

        // Cria instrução SQL de SELECT
        $sql = "SELECT * FROM produtos WHERE id = '$id'";

        // Instancia objeto PDO
        $conn = new PDO('mysql:host=localhost;dbname=livro;','root','');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        // executa instrução SQL
        $result = $conn->query($sql);
        $data = $result->fetch(PDO::FETCH_ASSOC);

        unset($conn);
        return $data;
    }
}

class Produto {

    // Atributos
    public $id;
    public $descricao;
    public $estoque;
    public $preco_custo;
}

// Instancia objeto ProdutoGateway
$gateway = new ProdutoGateway;

$vinho = new Produto;

$vinho->id          = 1;
$vinho->descricao   = 'Vinho';
$vinho->estoque     = 10;
$vinho->preco_custo = 15;

// insere o objeto no banco de dados
$gateway->insert($vinho);

// exibe o objeto de código 1
echo "<pre>";
print_r($gateway->getObject(1));

$vinho->descricao = 'Vinho Cabernet';

// atualiza o objeto no banco de dados
$gateway->update($vinho);

// exibe o objeto de código 1
print_r($gateway->getObject(1));
