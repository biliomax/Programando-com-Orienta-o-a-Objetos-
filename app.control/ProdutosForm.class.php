<?php
/**
 * classe ProdutosForm
 * formulário de cadastro de Produtos
 */
class ProdutosForm extends TPage {

    private $form; // formulário
    /**
     * método construtor
     * cria a página e o formulário de cadastro
     */
    function __construct(){
        
        parent::__construct();

        // instancia um formulário
        $this->form = new TForm('form_produtos');

        // instnacia uma tabela
        $table = new TTable;

        // adiciona a tabela ao formulário
        $this->form->add($table);

        // cria os campos do formulário
        $codigo         = new TEntry('id');
        $descricao      = new TEntry('descricao');
        $estoque        = new TEntry('estoque');
        $preco_custo    = new TEntry('preco_custo');
        $preco_venda    = new TCombo('preco_venda');
        $fabricante     = new TCombo('fabricante');

        // define alguns atributos para os campos do formulário
        // $codigo->setEditable(FALSE);
        // $codigo->setSize(100);
        // $nome->setSize(300);
        // $endereco->setSize(300);

        // carrega os fabriantes do banco de dados
        TTransaction::open('my_livro');

        // instancia um repositório de Fabricante
        $repository = new TRepository('Fabricante');

        // carrega todos os objetos
        $collection = $repository->load(new TCriteria);

        // adiciona objetos na combo
        foreach($collection as $object){

            $items[$object->id] = $object->nome;
        }

        $fabricante->addItems($items);
        TTransaction::close();

        // adiciona uma linha para o campo código
        $row = $table->addRow();
        $row->addCell(new TLabel('Código:'));
        $row->addCell($codigo);
       
        // adiciona uma linha para o campo Descrição
        $row = $table->addRow();
        $row->addCell(new TLabel('Descrição:'));
        $row->addCell($descricao);
               
        // adiciona uma linha para o campo Estoque
        $row = $table->addRow();
        $row->addCell(new TLabel('Estoque:'));
        $row->addCell($estoque);
               
        // adiciona uma linha para o campo Preço Custo
        $row = $table->addRow();
        $row->addCell(new TLabel('Preço Custo:'));
        $row->addCell($preco_custo);
               
        // adiciona uma linha para o campo Preço Venda
        $row = $table->addRow();
        $row->addCell(new TLabel('Preço Venda:'));
        $row->addCell($preco_venda);
               
        // adiciona uma linha para o campo Frabricante
        $row = $table->addRow();
        $row->addCell(new TLabel('Frabricante:'));
        $row->addCell($fabricante);

        // cria um botão de ação para o formulário
        $button1 = new TButton('action1');

        // define a ação do botão
        $button1->setAction(new TAction(array($this, 'onSave')), 'Salvar');

        // adiciona uma linha para a ação do formulário
        $row = $table->addRow();
        $row->addCell('');
        $row->addCell($button1);

        // define quais são os campos do formulário
        $this->form->setFields(array($codigo, $descricao, $estoque, $preco_custo, $preco_venda, $fabricante, $button1));

        // adiciona o formulário na página
        parent::add($this->form);
    }

    /**
     * método onEdit()
     * edita os dados de um registro
     */
    function onEdit($param){

        try {

            //inicia transação com o banco 'my_livro'
            TTransaction::open('my_livro');
            
            // obtém o produto de acordo com o parâmetro
            $produto = new ProdutoRecord($param['key']);

            // lança os dados do produto no formulário
            $this->form->setData($produto);

            // finaliza a transação
            TTransaction::close();

        } catch(Exception $e){ // em caso de exceção 

            // exibe a mensagem gerada pela exceção
            new TMessage('error', '<b>Erro</b>'. $e->getMessage());

            // desfaz todas alterações no banco de dados
            TTransaction::rollback();
        }
    }

    
    /**
     * método onSave()
     * executa quando o usuário clicar no botão salvar do formulário
     */
    function onSave(){
        
        try {
            // inicia transação com o banco 'my_livro'
            TTransaction::open('my_livro');

            // lê os dados do formulário e instancia um objeto ProdutoRecord
            $produto = $this->form->getData('ProdutoRecord');

            // armazena o objeto
            $produto->store();

            // finaliza a transação
            TTransaction::close();

            // exibe mensagem de sucesso
            new TMessage('info', 'Dados armazenado com sucesso');

        } catch(Exception $e){ // em caso de exceção

            // exibe a mensagem gerada pela exeção
            new TMessage('error', '<b>Erro</b>'. $e->getMessage());

            // deções nsfaz todas alterações no banco de dados
            TTransaction::rollback();
        }
    }
}