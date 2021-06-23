<?php
/**
 * classe TAction
 * encapsula uma ação
 */
class TAction {

    private $action;
    private $param;

    /**
     * método __construct()
     * instancia uma nova ação
     * @param $action = método a ser executado
     */
    public function __construct($action) {
        $this->action = $action;
    }

    /**
     * método setParameter
     * acrescenta um parâmetro ao método a ser executado
     * @param $param = nome do parâmetro
     * @param $value = valor do parâmetro
     */
    public function setParameter($param, $value){
        $this->param[$param] = $value;
    }

    /**
     * método serialize()
     * transforma a ação em uma string do tipo URL
     */
    public function serialize(){

        // vrifica se a ação é um método
        if(is_array($this->action)){

            // obtém o nome da classe
            $url['class'] = get_class($this->action[0]);

            // obtém o nome do método
            $url['method'] = $this->action[1];
        }
        elseif(is_string($this->action)){ // é uma string

            // obtém o nome da função
            $url['method'] = $this->action;
        }

        // verifica se há parâmetros
        if($this->param){
            $url = array_merge($url, $this->param);
        }

        // monta a URL
        return '?'.http_build_query($url);
    }
}
<?php
/**
 * classe TButton
 * responsável por exibir um botão
 */
class TButton extends TField {

    private $action;
    private $label;
    private $formName;

    /**
     * método setAction
     * define a ação do botão (função a ser executada)
     * @param $action = ação do botão
     * @param $label = rótulo do botão
     */
    public function setAction($action, $label){

        $this->action = $action;
        $this->label  = $label;
    }

    /**
     * método setFormName
     * define o nome do formulário para a ação botão
     * @param $name = nome do formulário
     */
    public function setFormName($name){

        $this->formName = $name;
    }

    /**
     * método show()
     * exibe o botão
     */
    public function show(){

        $url = $this->action->serialize();

        // define as propriedades do botão
        $this->tag->name    = $this->name;  // nome da TAG
        $this->tag->type    = 'button';     // tipo de input
        $this->tag->value   = $this->label; // rótulo do botão

        // se o campo não é editável
        if(!parent::getEditable()){

            $this->tag->disabled = "1";
            $this->tag->class    ='tfield_disabled'; // classe CSS
        }

        // define a ação do botão
        $this->tag->onclick = "document.{this->FormName}.action='{$url}'; ".
                              "document.{this->formName}.submit()";

        // exibe o botão
        $this->tag->show();
    }
}
<?php
/**
 * classe TCheckButton
 * classe para construção de botões de verificação
 */
class TCheckButton extends TField {
    
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name = $this->name; // nome da TAG
        $this->tag->value = $this->value; // valor
        $this->tag->type = 'checkbox'; // tipo do input

        // se o campo não é editável
        if(!parent::getEditable()){

            // desabilita a TAG input
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // class CSS
        }

        // exibe a tag
        $this->tag->show();
    }
}
<?php
/**
 * classe TCheckGrup
 * classe para exibição um grupo de TCheckButtons
 */
class TCheckGrup extends TField {
    
    private $layout = 'vertical';
    private $items;

    /**
     * método setLayout()
     * define a direção das opções (vertical ou horizontal)
     */
    public function setLayout($dir){
        $this->layout = $dir;
    }

    /**
     * método addItems($items)
     * adiciona itens ao check group
     * @param $items = um vetor indexado de itens
     */
    public function addItems($items){
        $this->items = $items; // Esse $items é o parametro dentro da função
    }

    /**
     * método show()
     * exibe a widget na tela
     */
    public function show(){
        
        if($this->items){

            // percorre cada uma das opções do rádio
            foreach($this->items as $index => $label){

                $button = new TCheckButton("{$this->name}[]");
                $button->setValue($index);

                // verifica se deve ser marcado
                if(@in_array($index, $this->value)){
                    
                    $button->setProperty('checked', '1');
                }
                
                $button->show();
                $obj = new TLabel($label);
                $obj->show();

                if($this->layout == 'vertical'){

                    // exibe uma tag de quebra de linha
                    $br = new TElement('br');
                    $br->show();
                    echo "\n";
                }
            }
        }
    }
}
<?php
/**
 * classe TCombo
 * classe para construção de combo boxes
 */
class TCombo extends TField {

    private $items; // array contendo os itens da combo
    
    /**
     * método construtor
     * instancia a combo box
     * @param $name = nome do campo
     */
    public function __construct($name){
        
        // executa o método contrutor da classe-pai
        parent::__construct($name);
        // cria uma tag HTML do tipo <select>
        $this->tag = new TElement('select');
        $this->tag->class = 'tfield'; // class CSS
    }

    /**
     * método addItems()
     * adiciona items à combo box
     * @param $items = array de itens
     */
    public function addItems($items){
        $this->items = $items;
    }

    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name = $this->name; // nome da TAG
        $this->tag->style = "width:{$this->size}"; // tamanho em pixels

        // cria uma TAG <option> com um valor padrão
        $option = new TElement('option');
        $option->add('');
        $option->value = '0'; // valor da TAG
        // adiciona a opção à combo
        $this->tag->add($option);

        if($this->items){

            // percorre os items adicionados
            foreach($this->items as $chave => $item){

                // cria uma TAG <option> para o item
                $option = new TElement('option');
                $option->value = $chave; // define o índice da opção
                $option->add($item); // adiciona o texto da opção

                // caso seja a opção selecionada
                if($chave == $this->value){

                    // seleciona o item da combo
                    $option->selected = 1;
                }
                // adiciona a opção à combo
                $this->tag->add($option);
            }
        }

        // verifica se o campo é editável
        if(!parent::getEditable()){

            // desabilita a TAG input
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }

        // exibe a combo
        $this->tag->show();
    }
}
<?php
/**
 * classe TDataGrid
 * classe para construção de Listagens
 */
class TDataGrid extends TTable {

    private $columns;
    private $actions;
    private $rowcount;

    /**
     * método __construct()
     * instancia uma nova DataGrid
     */
    public function __construct(){

        parent::__construct();
        $this->class = 'tdatagrid_table';

        // instancia objeto TStyle
        // este estilo será utilizado para a tabela da datagrid
        $style1 = new TStyle('tdatagrid_table');
        $style1->border_collapse    = 'separete';
        $style1->font_family        = 'arial,verdana,sans-serif';
        $style1->font_size          = '10pt';
        $style1->border_spacing     = '0pt';

        // instancia objeto TSyle
        // Este stilo será utilizado para os cabeçalhos da datagrid
        $style2 = new TStyle('tdatagrid_col');
        $style2->font_size          = '10pr';
        $style2->font_weight        = 'bold';
        $style2->border_left        = '1px solid white';
        $style2->border_top         = '1px solid white';
        $style2->border_right       = '1px solid gray';
        $style2->border_bottom      = '1px solid gray';
        $style2->padding_top        = '1px';
        $style2->background_color   = '#CCCCCC';

        // instancia objeto TSyle
        // Este estilo será utilizado quando
        // o mouse estiver sobre um cabeçalho da datagrid
        $style3 = new TStyle('tdatagrid_col_over');
        $style3->font_size          = '10pt';
        $style3->font_weight        = 'bold';
        $style3->border_left        = '1px solid white';
        $style3->border_top         = '2px solid orange';
        $style3->border_right       = '1px solid gray';
        $style3->border_bottom      = '1px solid gray';
        $style3->padding_top        = '0px';
        $style3->cursor             = 'pointer';
        $style3->background_color   = '#dcdcdc';

        // exibe estilos na tela
        $style1->show();
        $style2->show();
        $style3->show();
    }

    /**
     * métoodo addColum()
     * adiciona uma coluna à listagem
     * @param $object = objeto do tipo TDataGridColumn
     */
    public function addColum(TDataGridColumn $object){
        
        $this->colums[] = $object;
    }

    /**
     * métodp addAction()
     * adiciona uma ação à listagem
     * @param $object = objeto do tipo TDataGridAction
     */
    public function addAction(TDataGridAction $object){

        $this->action[] = $object;
    }

    /**
     * método clear()
     * elimina todas linhas de dados da DataGrid
     */
    function clear(){

        // faz uma cópia de cabeçalho
        $copy = $this->children[0];

        // inicia o vetor de linhas
        $this->children = array();

        // acrescenta novamente o cabeçalho
        $this->children[] = $copy;

        // zera a contagem de linhas
        $this->rowcount;
    }

    /**
     * método createModel()
     * cria a estrutura da Grid, com ser cabeçalho
     */
    public function createModel(){

        // adiciona uma linha à tabela
        $row = parent::addRow();

        // adiciona células para as ações
        if($this->actions){

            foreach($this->actions as $action){

                $celula = $row->addCell('');
                $celula->class = 'tdatagrid_col';
            }
        }

        // percorre as colunas da listagem
        foreach($this->columns as $column){

            // obtém as propriedade da coluna
            $name   = $column->getName();
            $label  = $column->getLabel();
            $align  = $column->getAlign();
            $width  = $column->getWidth();

            // adiciona a célula com a coluna
            $celula = $row->addCell($label);
            $celula->class = 'tdatagrid_col';
            $celula->align = $align;
            $celula->width = $width;

            // verifica se a coluna tem uma ação
            if($column->getAction()){

                $url = $column->getAction();
                $celula->onmouseover = "this.className='tdatagrid_col_over';";
                $celula->onmousout   = "this.className='tdatagrid_col';";
                $celula->onclick     = "document.location='$url'";
            }
        }
    }

    /**
     * método addItem()
     * adiciona um objeto na grid
     * @param $object = Objeto que contém os dados
     */
    public function addItem($object){

        // cria um estilo com com variável
        $bgcolor = ($this->rowcount % 2) == 0 ? '#ffffff' : '#e0e0e0';
        
        // adiciona uma linha na DataGrid
        $row = parent::addRow();
        $row->bgcolor = $bgcolor;

        // verifica se a listagem possui ações
        if($this->actions){

            // percorre as ações
            foreach($this->actions as $action){

                // obtém  as propriedades da ação
                $url    = $action->serialize();
                $label  = $action->getLabel();
                $image  = $action->getImage();
                $field  = $action->getField();

                // obtém o campo do objeto que será passado adiante
                $key    = $object->$field;

                // cria um link
                $link = new TElement('a');
                $link->href = "{$url}&key={$key}";

                // verifica se o link será com imagem ou com texto
                if($image){

                    // adiciona a imagem ao link
                    $image = new TImage("app.images/$image");
                    $link->add($image);

                } else {
                    // adiciona o rótulo de texto ao link
                    $link->add($label);
                }

                // adiciona a célula à linha
                $row->addCell($link);
            }
        }
        if($this->columns){

            // percorre as colunas da DataGrid
            foreach($this->columns as $column){

                // obtém as propriedades da coluna
                $name   = $column->getName();
                $align  = $column->getAling();
                $width  = $column->getWidth();

                $function = $column->getTransformer();
                $data     = $object->$name;

                // verifica se há função para transformar os dados
                if($function){

                    // aplica a função sobre os dados
                    $data = call_user_func($function, $data);
                }

                // adiciona a célula na linha
                $celula = $row->addCell($data);
                $celula->align = $align;
                $celula->width = $width;
            }
        }

        // incrementa o contador de linhas
        $this->rowcount ++;
    }
}

<?php
/**
 * class TDataGridAction
 * representa uma ação de uma listagem
 */
class TDataGridAction extends TAction {

    private $image;
    private $label;
    private $field;

    /**
     * método setImage()
     * atribui uma imagem à ação
     * @param $iamge = local do arquivo de iamgem
     */
    public function setImage($image){

        $this->image = $image;
    }

    /**
     * método getImagem()
     * retorna a imagem da ação
     */
    public function getImage(){

        return $this->image;
    }

    /**
     * método setLabel()
     * define o rótulo de texto da ação
     * @param $label = rótulo de texto da ação
     */
    public function setLabel($label){

        $this->label = $label;
    }

    /**
     * método getLabel()
     * retorna o rótulo de texto da ação
     */
    public function getLabel(){

        return $this->label;
    }

    /**
     * método setField()
     * define o nome do campo do banco de dados que será passado juntamente com a ação
     * @param $field = nome do campo do banco de dados
     */
    public function setField($field){

        $this->field = $field;
    }

    /**
     * método getField()
     * retorna o nome do campo de dados definido pelo método setField()
     */
    public function getField(){

        return $this->field;
    }
}
<?php
/**
 * class TDataGridColumn
 * representa uma coluna de uma listagem
 */
class TDataGridColumn {

    private $name;
    private $label;
    private $align;
    private $width;
    private $action;
    private $transformer;

    /**
     * método __construct()
     * instancia uma coluna nova
     * @param $name     = nome da coluna no banco de dados
     * @param $label    = rótulo de texto que será exibido
     * @param $align    = alinhamento da coluna (left, center, right)
     * @param $width    = largura da coluna (em pixels)
     */
    public function __construct($name, $label, $align, $width){

        // atribui os parâmetros às propriedades do objeto
        $this->name     = $name;
        $this->label    = $label;
        $this->align    = $align;
        $this->width    = $width;
    }

    /**
     * método getName()
     * retorna o nome da coluna no banco de dados
     */
    public function getName(){
        
        return $this->name;
    }

    /**
     * método getLabel()
     * retorna o nome do rótulo de texto da coluna
     */
    public function getLabel(){
        
        return $this->label;
    }

    /**
     * método getAlign()
     * retorna o alinhamento da coluna (left, center, right)
     */
    public function getAlign(){
        
        return $this->align;
    }

    /**
     * método getWidth()
     * retorna a largura da coluna (em pixels)
     */
    public function getWidth(){

        return $this->width;
    }

    #?class=PessoasList&method=ordenar

    /**
     * método setAction()
     * define uma ação a ser executada quando o usuário
     * clicar sobre o título da coluna
     * @param $action = objeto TAction contendo a ação
     */
    public function setAction(TAction $action) {
        
        $this->action = $action;
    }

    /**
     * método getAction()
     * retorna a ação vinculada à coluna
     */
    public function getAction(){

        // verifica se a coluna possui ação
        if($this->action){

            return $this->action->serialize();
        }
    }

    /**
     * método setTransformer()
     * define uma função (callback) a ser aplicada sobre
     * todo dado contido nesta colua
     * @param $callback = função do PHP ou do usuário
     */
    public function setTransformer($callback){
        
        $this->transformer = $callback;
    }

    /**
     * método getTransformer()
     * retorna a função (callback) aplica à coluna
     */
    public function getTransformer(){

        return $this->transformer;
    }
}
<?php

/**
 * classe TElement
 * classe para abstração de tags HTML
 */
class TElement {
    private $name;          // nome da TAG
    private $properties;    // propriedades da TAG
    
    /**
     * método construtor
     * instancia uma tag html
     * @param $name = nome da tag 
     */
    public function __construct($name)
    {
        // define o nome do elemento
        $this->name = $name;
    }

    /**
     * método __set()
     * intercepta as atribuições á propriedades do objeto
     * @param $name  = nome da propriedade
     * @param $value = valor
     */
    public function __set($name, $value){
       
        // armazena os valores atribuídos
        // ao array properties
        $this->properties[$name] = $value;
    }

    /**
     * método add()
     * adiciona um elemento filho
     * @param $child = objeto filho
     */
    public function add($child){
        $this->children[] = $child;
    }

    /**
     * método open()
     * exibe a tag de abertura na tela
     */
    private function open(){

        // exibe a tag de abertura
        echo "<{$this->name}";

        if($this->properties){

            // percorre as propriedades
            foreach ($this->properties as $name=>$value){
                echo " {$name}=\"{$value}\"";
            }
        }
        echo '>';
    }

    /**
     * método show()
     * exibe a tag na taela, justamente com seu conteúdo
     */
    public function show(){

        // abre a tag
        $this->open();
        echo "\n";

        // se possui conteúdo
        if($this->children){

            // percorre todos objetos filhos
            foreach($this->children as $child){

                // se for objeto
                if(is_object($child)){
                    $child->show();
                }
                else if((is_string($child)) or (is_numeric($child))){

                    // se for texto
                    echo $child;
                }
            }
            // fecha a tag
            $this->close();
        }
    }

    /**
     * método close()
     * Fecha uma tag HTML
     */
    private function close(){
        echo "</{$this->name}>\n";
    }
}
<?php
/**
 * classe TEntry
 * classe para construção de caixas de texto
 */
class TEntry extends TField {
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name    = $this->name; // noma da TAG
        $this->tag->value   = $this->value; // valor da TAG
        $this->tag->type    = 'text'; // tipo de input
        $this->tag->style   = "width:{$this->size}"; // tamanho em pixels

        // se o campo não é editável
        if(!parent::getEditable()){
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }

        // exibe a tag
        $this->tag->show();
    }

}
<?php
/**
 * classe TField
 * classe base para construção dos widgets para formulários
 */
abstract class TField {

    protected $name;
    protected $size;
    protected $value;
    protected $editable;
    protected $tag;

    /**
     * método construtor
     * instancia um campo do formulário
     * @param $name = nome do campo
     */
    public function __construct($name)
    {
        // define algumas características iniciais
        self::setEditable(true);
        self::setName($name);
        self::setSize(200);

        // instancia um estilo CSS chamado tfield
        // que será utilizado pelos campos do formulário
        $style1 = new TStyle('tfield');
        $style1->border           = 'solid';
        $style1->border_color     = '#a0a0a0';
        $style1->border_width     = '1px';
        $style1->z_index          = '1';

        $style2 = new TStyle('tfield_disabled');
        $style2->border           = 'solid';
        $style2->border_color     = '#a0a0a0';
        $style2->border_width     = '1px';
        $style2->backgroun_color  = '#e0e0e0';
        $style2->color            = '#a0a0a0';

        $style1->show();
        $style2->show();

        // cria uma tag HTML do tipo <input>
        $this->tag = new TElement('input');
        $this->tag->class = 'tfield'; // classe CSS
    }

    /**
     * método setName()
     * define o nome do widget
     * @param $name = nome do widget
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * método getName()
     * retorna o nome do widget
     */
    public function getName(){
        return $this->name;
    }

    /**
     * método setValue()
     * define o valor de campo
     * @param $value = valor do campo
     */
    public function setValue($value){
        $this->value = $value;
    }

    /**
     * método getValue()
     * retorna o valor de um campo
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * método setEditable()
     * define se o campo poderá ser editado
     * @param $editable = TRUE ou FALSE
     */
     public function setEditable($editable){
        $this->editable = $editable;
     }

     /**
      * método getEditable()
      * retorna o valor da propriedade $editable
      */
      public function getEditable(){
          return $this->editable;
      }

      /**
       * método setProperty()
       * define uma propriedade para o campo
       * @param $name = nome da propriedade
       * @param $valor = valor da propriedade
       */
      public function setProperty($name, $value){

        // define uma propriedade de $this->tag
        $this->tag->$name = $value;
      }

      /**
       * método setSize()
       * define a largura do widget
       * @param $size = tamnho em pixels
       */
      public function setSize($size){
          $this->size = $size;
      }
}
<?php
/**
 * classe TFile
 * classe para construção de botões de arquivos
 */
class TFile extends TField {
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name    = $this->name; // noma da TAG
        $this->tag->value   = $this->value; // valor da TAG
        $this->tag->type    = 'file'; // tipo de input

        // se o campo não é editável
        if(!parent::getEditable()){

            // desabilita a TAG input
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }

        // exibe a tag
        $this->tag->show();
    }
}
<?php
/**
 * classe TForm
 * classe para construção de formulários
 */
class TForm {
    protected $fields;  // array de objetos contidos pelo form
    private     $name;  // nome do formulário

    /**
     * método construtor
     * instancia o formulário
     * @param $name = nome do formulário
     */
    public function __construct($name = 'my_form') {
        $this->setName($name);
    }

    /**
     * método setName()
     * define o mome do formulário
     * @param $name = nome do formulário
     */
    public function setName($name){
        $this->name = $name;
    }

    /**
     * método setEditable
     * define se o formulário poderá ser editado
     * @param $bool = TRUE ou FALSE
     */
    public function setEditTable($bool){
        if($this->fields){
            
            foreach($this->fields as $object){
                
                $object->setEditTable($bool);
            }
        }
    }

    /**
     * método setFields()
     * define quais são os campos do formulário
     * @param $fields = array de objetos TField
     */
    public function setFields($fields){
        
        foreach($fields as $field){

            if($field instanceof TField){

                $name = $field->getName();
                $this->fields[$name] = $field;
    
                if($field instanceof TButton){

                    $field->setFormName($this->name);
                }
            }
        }
    }

    /**
     * método getField()
     * retorna um campo do formulário por seu nome
     * @param $name = nome do campo
     */
    public function getFieds($name) {

        return $this->fields[$name];
    }

    /**
     * método setData()
     * atribui dados aos campos do formulário
     * @param $object = objeto com dados
     */
    public function setData($object){

        foreach($this->fields as $name => $field){

            if($name){ // labels não possuem nome

                $field->setValue($object->$name);
            }
        }
    }

    /**
     * método getData()
     * retorna os dados do formulário em forma de objeto
     */
    public function getData($class = 'StdClass'){
        
        $object = new $class;
        foreach($_POST as $key => $val){

            if(get_class($this->fields[$key]) == 'TCombo'){
                if($val !== '0'){
                    $object->$key = $val;
                }
            } else {
                $object->$key = $val;
            }
        }

        // percorre os arquivos de upload
        foreach($_FILES as $key => $content){

            $object->$key = $content['tmp_name'];
        }

        return $object;
    }

    /**
     * método add()
     * adiciona um objeto no formulário
     * @param $object = objeto a ser adcionado
     */
    public function add($object){

        $this->child = $object;
    }

    /**
     * método show()
     * Exibe o formulário na tela
     */
    public function show(){

        // instancia TAG de formulário
        $tag = new TElement('form');
        $tag->name = $this->name;   // nome do formulário
        $tag->method = 'post'; // método de transferência

        // adiciona o objeto filho ao formulário
        $tag->add($this->child);

        // exibe o formulário
        $tag->show();
    }

}
<?php
/**
 * classe THidden
 * classe para construção de campos escondidos
 */
class THidden extends TField {
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name    = $this->name; // noma da TAG
        $this->tag->value   = $this->value; // valor da TAG
        $this->tag->type    = 'hidden'; // tipo de input
        $this->tag->style   = "width:{$this->size}"; // tamanho em pixels

        // exibe a tag
        $this->tag->show();
    }
}
<?php
/**
 * classe TImage
 * classe para exibição de imagens
 */
class TImage extends TElement {
    private $source;    // localização da imagem
    #private $tag;       // objeto TElement

    /**
     * método construtor
     * instancia objeto TImage
     * @param $source = localização da imagem
     */
    public function __construct($source) {
        
        // atribui a localização da image
        #$this->source = $source;
        // instancia objeto TElemnt
        #$this->tag  = new TElement('img');
        
        parent:: __construct('img');
        // atribui a localizaçao da imagem
        $this->src = $source;
        $this->border = 0;
    }

    /**
     * método show()
     * exibe imagem na tela
     */
    // public function show(){
    //     // define algumas propriedades da tag
    //     $this->tag->src = $this->source;
    //     $this->tag->border = 0;

    //     // exibe tag na tela
    //     $this->tag->show();
    // }
}
<?php
/**
 * classe TLabel
 * classe para construção de rótulos de texto
 */
class TLabel extends TField {

    private $fontSize;  // tamanho da fonte
    private $fontFace;  // nome da fonte
    private $fontColor; // cor da fonte

    /**
     * método constutor
     * instancia o label, cria um objeto <font>
     * @param $value = Texto do Label
     */
    public function __construct($value) {
        
        // atribui o conteúdo do label
        $this->setValue($value);

        // instancia um elemento <font>
        $this->tag = new TElement('font');

        // define valores iniciais às propriedades
        $this->fontSize  = 14;
        $this->fontFace  = 'Arial';
        $this->fontColor = 'black';
    }

    /**
     * método setSize()
     * define o tamnho da fonte
     * @param $size = tamanho da fonte
     */
    public function setFontSize($size){
        $this->fontSize = $size;
    }

    /**
     * método setFontFace
     * define a família de fonte
     * @param $font = nome da fonte
     */
    public function setFontFace($font){
        $this->fontFace = $font;
    }

    /**
     * método setFontColor
     * define a cor da fonte
     * @param $colo = cor da fonte
     */
    public function setFontColor($color){
        $this->fontColor = $color;
    }

    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // define o estilo da tag
        $this->tag->style = "font-family:{$this->fontFace};".
        "color:{$this->fontColor};".
        "font-size:{$this->fontSize}";


        // adiciona o conteúdo à tag
        $this->tag->add($this->value);

        // exibe a tag
        $this->tag->show();
    }
}
<?php
/**
 * classe TMessagem
 * exibe mensagens ao usuário
 */
class TMessage {

    /**
     * método construtor
     * instancia objeto TMessage
     * @param $type = tipo de mensagem (info, error)
     * @param $message = messagem ao usuário
     */
    public function __construct($type, $message) {
        
        $style = new TStyle('tmessage');
        $style->position    = 'absolute';
        $style->left        = '30%';
        $style->top         = '30%';
        $style->width       = '300%';
        $style->height      = '150%';
        $style->color       = 'black';
        $style->backgroun   = '#DDDDDD';
        $style->border      = '4px solid #000000';
        $style->z_index     = '10000000000000000';

        // exibe o estilo na tela
        $style->show();

        // instancia o painel para exibir o diálogo
        $painel = new TElement('div');
        $painel->class = "tmessage";
        $painel->id    = "tmessage";

        // cria um botão que vai fechar o diálogo
        $button = new TElement('input');
        $button->type = 'button';
        $button->value = 'Fechar';
        $button->onclick = "document.getElementById('tmessage').style.display='nome'";

        // cria um tabela para organizar o layout
        $table = new TTable;

        $table->align = 'center';

        // cria uma linha para o ícone e a mensagem
        $row = $table->addRow();
        $row->addCell(new TImage("app.images/{$type}.jpg"));
        $row->addCell($message);

        // cria uma linha para o botão
        $row = $table->addRow();
        $row->addCell('');
        $row->addCell($button);

        // adiciona a tabela ao painél
        $painel->add($table);

        // exibe o painél
        $painel->show();
    }
}

<?php
/**
 * classe TPage
 * classe para conrole do fluxo de execução
 */
class TPage extends TElement {

    /**
     * método __constuct()
     */
    public function __construct(){
        
        // define o elemento que irá representar
        parent::__construct('html');
    }

    /**
     * método show()
     * exibe o conteúdo da página
     */
    public function show(){
        $this->run();
        parent::show();
    }

    /**
     * métodp run()
     * executa determinado método de acordo com os parâmetros recebido
     */
    public function run(){
        if($_GET){

            $class  = $_GET['class'];
            $method = $_GET['method'];

            if($class){

                $object = $class == get_class($this) ? $this: new $class;

                if(method_exists($object, $method)){
                    call_user_func(array($object, $method), $_GET);
                }
            }
            else if(function_exists($method)){
                call_user_func($method, $_GET);
            }
        }
    }
}
<?php
/**
 * classe TPanel
 * painel de posições fixas
 */
class TPanel extends TElement {
    /**
     * método __construct()
     * instancia objeto TPanel.
     * @param $width = largura do painel
     * @param $height = altura do painel
     */
    public function __construct($width, $height){
        
        // instancia objeto TStyle
        // para efinir as caracteristicas do painel
        $painel_style = new TStyle('tpanel');
        $painel_style->position         = 'relative';
        $painel_style->width            = $width;
        $painel_style->height           = $height;
        $painel_style->border           = '2px solid';
        $painel_style->border_color     = 'grey';
        $painel_style->background_color = '#f0f0f0';

        // exibe o estilo na tela
        $painel_style->show();

        parent::__construct('div');
        $this->class = 'tpanel';
    }

    /**
     * método put()
     * posiciona um objeto no painel
     * @param $widget = objeto a ser inserido no painel
     * @param $col = coluna em pixels.
     * @param $row = linha em pixels.
     */
    public function put($width, $col, $row){

        // cria ua camada para o widget
        $camada = new TElement('div');

        // define a posição da camada
        $camada->style = "position:absolute; left:{$col}px; top:{$row}px";

        // adiciona widget no array de elementos
        parent::add($camada);
    }
}
<?php
/**
 * classe TParagraph
 * classe para exibição de parágrafos
 */
class TParagraph extends TElement {

    /**
     * método construtor
     * instancia objeto TParagraph
     * @param $texto = texto a ser exibido
     */
    public function __construct($text) {
        parent::__construct('p');

        // atribui o conteúdo do texto
        parent::add($text);
    }

    /**
     * método setAlign()
     * define o alinhamento do texto
     * @param $align = alinhamento do texto
     */
    function setAlign($align){
        
        $this->align = $align;
    }
}
<?php
/**
 * classe TPassword
 * classe para construção de campos de digitação de senhas
 */
class TPassword extends TField {
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name    = $this->name; // noma da TAG
        $this->tag->value   = $this->value; // valor da TAG
        $this->tag->type    = 'text'; // tipo de input
        $this->tag->style   = "width:{$this->size}"; // tamanho em pixels

        // se o campo não é editável
        if(!parent::getEditable()){
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }

        // exibe a tag
        $this->tag->show();
    }

}
<?php
/**
 * classe TQuestion
 * Exibe perguntas ao usuário
 */
class TQuestion {
    /**
     * método contrutor
     * instancia objeto TQuestion
     * @param $message = pergunta as usuário
     * @param $action_yes = ação para resposta positiva
     * @param $action_no = ação para resposta negativa
     */
    function __construct($message, TAction $action_yes, TAction $action_no) {
        
        $style = new TStyle('tquestion');
        $style->position        = 'absolute';
        $style->left            = '30%';
        $style->top             = '30%';
        $style->width           = '300%';
        $style->height          = '150';
        $style->border_width    = '1px';
        $style->color           = 'black';
        $style->backgroun       = '#DDDDD';
        $style->border          = '4px solid #000000';
        $style->z_index         = '10000000000000000';

        // converte os nomes de métodos em URL's
        $url_ye = $action_yes->serialize();
        $url_no = $action_no->serialize();

        // exibe o estilo na tela
        $style->show();

        // instancia o painel para exibir o diálogo
        $painel = new TElement('div');
        $painel->class = 'tquestion';

        // cria um botão para a resposta positiva
        $button1 = new TElement('input');
        $button1->type = 'button';
        $button1->value = 'sim';
        $button1->onclick="javascript:location='$url_ye'";

        // cria um botão para a resposta negativa
        $button2 = new TElement('input');
        $button2->type = 'button';
        $button2->value = 'Não';
        $button2->onclick="javascript:location='$url_no'";

        // cria uma tabela para organizar o layout
        $table = new TTable;
        $table->align = 'center';
        $table->cellspacing = 10;

        // cria uma linha para o ícone e a mensagem
        $row = $table->addRow();
        $row->addCell(new TImage('app.images/icon.jpg'));
        $row->addCell($message);

        // cria uma linha para os botões
        $row = $table->addRow();
        $row->addCell($button1);
        $row->addCell($button2);

        // adiciona a tabela ao painél
        $painel->add($table);

        // exibe o painel
        $painel->show();
    }
}
<?php
/**
 * classe TRadioButton
 * classe para construção de rádio
 */
class TRadioButton extends TField {
    
    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name = $this->name;     // nome da TAG
        $this->tag->value = $this->value;   // valor
        $this->tag->type = 'radio';         // tipo do input

        // se o campo não é editável
        if(!parent::getEditable()){

            // desabilita a TAG input
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // class CSS
        }

        // exibe a tag
        $this->tag->show();
    }
}
<?php
/**
 * classe TRadioGrup
 * classe para exibição um grupo de Radio Buttons
 */
class TRadioGrup extends TField {
    
    private $layout = 'vertical';
    private $items;

    /**
     * método setLayout()
     * define a direção das opções (vertical ou horizontal)
     */
    public function setLayout($dir){
        $this->layout = $dir;
    }

    /**
     * método addItems($items)
     * adiciona itens (botões de rádio)
     * @param $items = array indexado contendo os itens
     */
    public function addItems($items){

        $this->items = $items; // Esse $items é o parametro dentro da função
    }

    /**
     * método show()
     * exibe a widget na tela
     */
    public function show(){
        
        if($this->items){

            // percorre cada uma das opções do rádio
            foreach($this->items as $index => $label){

                $button = new TRadioButton($this->name);
                $button->setValue($index);

                // se possui qualquer valor
                if($this->value == $index){

                    // marca o radio button
                    $button->setProperty('checked', '1');
                }
                
                $button->show();
                $obj = new TLabel($label);
                $obj->show();

                if($this->layout == 'vertical'){

                    // exibe uma tag de quebra de linha
                    $br = new TElement('br');
                    $br->show();
                }
                echo "\n";
            }
        }
    }
}
<?php
/**
 * clsse TStyle
 * classe para abstração Estilos CSS
 */
class TStyle {
    private $name;  // nome do estilo
    private $properties;    // atributos
    static private $loaded; // array de etilos carregados

    /**
     * método construtor
     * instancia uma tag html
     * @param $name = nome da tag
     */

     public function __construct($name){

        // atribui o nome do estilo
        $this->name = $name;         
     }

     /** 
      * método __set()
      * intercepta as atribuições à propriedades di objeto
      * @param $name    = nome da propriedade
      * @param $value = valor
      */
      public function __set($name, $value){
          
        // substitui o "_" por "-" no nome da propriedade
        $name = str_replace('_', '-', $name);

        // armazena os valores atribuidos ao array properties
        $this->properties[$name] = $value;
      }

      /**
       * método show()
       * exibe a tag na tela
       */
      public function show(){

        // verifica se este estilo já foi carregado
        if(!self::$loaded[$this->name]){

            echo "<style type='text/css' media='screen'>\n";

            // exibe a abertura do estilo
            echo ".{$this->name}\n";
            echo "{\n";
            
            if($this->properties){
                // percorre as propriedades
                foreach($this->properties as $name => $value){
                    echo "\t {$name}: {$value};\n";
                }
            }
            echo "}\n";
            echo "</style>\n";

            // marca o estilo como já carregado
            self::$loaded[$this->name] = TRUE;
        }
      }
}
<?php
/**
 * classe TTable
 * responsável pela exibição de tabelas
 */
class TTable extends TElement {

    /**
     * método construtor
     * instancia uma ova tabela
     */
    public function __construct(){
        parent::__construct('table');
    }

    /**
     * método addRow
     * agrega um novo objeto linha (TTableRow) na tabela
     */
    public function addRow(){
        
        // instancia objeto linha
        $row = new TTableRow;

        // armazena no array de linhas
        parent::add($row);
        return $row;
    }
}
<?php
/**
 * classe TTableCell
 * responsável pela exibição de uma célula de uma tabela
 */
class TTableCell extends TElement {

    /**
     * método construtor
     * instancia uma nova célula
     * @param $value = conteúdo da celula
     */
    public function __construct($value){
        
        parent::__construct('td');
        parent::add($value);
    }
}
<?php
/**
 * classe TTableRow
 * responsável pela exibição de um tabela
 */
class TTableRow extends TElement {

    /**
     * método constutor
     * instancia uma nova linha
     */
    public function __construct(){
        parent::__construct('tr');        
    }

    /**
     * método addCell
     * agrega um novo objeto célula (TTableCell) à linha
     * @param $value = conteúdo da célula
     */
    public function addCell($value){

        // imstancia objeto célula
        $cell = new TTableCell($value);
        parent::add($cell);

        // retorna o objeto instanciado
        return $cell;
    }
}
<?php
/**
 * classe TText
 * classe para construção de caixas de texto
 */
class TText extends TField {

    private $width;
    private $height;

    /**
     * método construtor
     * instancia um novo objeto
     * @param $name = nome do campo
     */
    public function __construct($name){
        
        // executa o método construtor da classe-pai.
        parent::__construct($name);

        // cria uma TAG HTML do tipo <textarea>
        $this->tag = new TElement('textarea');
        $this->tag->class = 'tfield';   // classe CSS

        // define a altura padrão da caixa de texto
        $this->height = 100;
    }

    /**
     * método setSize()
     * define o tamanho de um campo de texto
     * @param $width    = largura
     * @param $height   = altura
     */
    public function setSize($width, $height){
        
        $this->size = $width;
        $this->height = $height;
    }

    /**
     * método show()
     * exibe o widget na tela
     */
    public function show(){

        // atribui as propriedades da TAG
        $this->tag->name    = $this->name; // noma da TAG
        $this->tag->style   = "width:{$this->size};height:{$this->height}"; // tamanho em pixels

        // se o campo não é editável
        if(!parent::getEditable()){
            
            // desabilita a TAG input
            $this->tag->readonly = "1";
            $this->tag->class = 'tfield_disabled'; // classe CSS
        }

        // adiciona conteúdo ao textarea
        $this->tag->add(htmlspecialchars($this->value));

        // exibe a tag
        $this->tag->show();
    }

}
<?php
/**
 * TWindow é um container que exibe seu contéudo em uma camada simulando uma janela
 */
class TWindow {
    private $x;         // coluna
    private $y;         // linha
    private $width;     // largura
    private $height;    // altura
    private $content;   // conteúdo da janela
    static private $counter;    // contador
    
    /**
     * método construtor
     * incrementa o contador de janelas
     */
    public function __construct($title){
        
        // incrementa o contador de janelas
        // paa exibir cada um com um ID diferente
        self::$counter ++;
        $this->title = $title;
    }

    /**
     * método setPosition()
     * define a coluna e linha (x,y) que a janela será exibido na tela
     * @param $x = coluna (em pixels)
     * @param $Y = coluna (em pixels)
     */
    public function setPosition($x, $y){

        // atribui os pontos cordinais do canto superior esquerdo da janela
        $this->x = $x;
        $this->y = $y;
    }

    /**
     * método setSize()
     * define a largura e altura da janela em tela
     * @param $width = largura (e, pixels)
     * @param $height = largura (e, pixels)
     */
    public function setSize($width, $height){

        // atribui as dimensões
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * método add()
     * adiciona um conteúdo à janela 
     * @param $content = conteúdo a ser adicionado
     */
    public function add($content){
        $this->content = $content;
    }

    /**
     * métodp show()
     * exibe a janela na tela
     */
    public function show(){

        $window_id = 'TWindow'.self::$counter;

        // instancia objeto TStyle para definir as características
        // de posicionamento e dimensão da camada criada
        $style = new TStyle($window_id);
        $style->position    = 'absolute';
        $style->left        =  $this->x;
        $style->top         =  $this->y;
        $style->width       =  $this->width;
        $style->height      =  $this->height;
        $style->background  =  '#e0e0e0';
        $style->border      =  '1px solid #000000';
        $style->z_index     =  '1000';

        // exibe o estilo em tela
        $style->show();

        // cria tag <div> para a camada que representará a janela
        $painel = new TElement('div');
        $painel->id       = $window_id; // define o ID
        $painel->class    = $window_id; // define a classe CSS
        
        // instancia objeto TTable
        $table = new TTable;

        // define as propriedades da tabela
        $table->width  = '100%';
        $table->heigth = '100%';
        $table->style  = 'border-collapse:collapse';

        // adiciona uma linha para o título
        $row1 = $table->addRow();
        $row1->bgcolor = '#707070';
        $row1->heigth  = '20PX';

        // adiciona uma célula para o título
        $titulo = $row1->addCell("<font face=Arial size=2 color=white><b>{$this->title}</b></font>");
        $titulo->width = '100%';

        // cria um link com ação para esconder o <div>
        $link = new TElement('a');
        $link->add(new TImage("app.images/gnome.png"));
        $link->onclik = "document.getElementById('$window_id').style.display='none'";

        // adiciona uma célula com o link de fechar
        $cell = $row1->addCell($link);

        // cria uma linha para o conteúdo
        $row2 = $table->addRow();
        $row2->valign = 'top';

        // adiciona o conteúdo ocupando duas colunas (colspan)
        $cell = $row2->addCell($this->content);
        $cell->colspan = 2;

        // adiciona a tabela ao painel
        $painel->add($table);

        // exibe o painel
        $painel->show();
    }
}
