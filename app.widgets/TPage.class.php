
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
