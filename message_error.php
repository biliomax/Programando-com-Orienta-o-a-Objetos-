<?php
function __autoload($classe){

    if(file_exists("app.widgets/{$classe}.class.php")){
        include_once "app.widgets/{$classe}.class.php";
    }
}

// exibe uma mensagem de informação
new TMessage('icon', 'Agora eu estou falando sério. Este erro é fatal');