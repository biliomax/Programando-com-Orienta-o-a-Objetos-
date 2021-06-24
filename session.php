<?php

include_once 'app.widgets/TSession.class.php';

new TSession;

if(!TSession::getValue('counted')){

    echo 'registrando visita';
    TSession::setValue('counted', true);

} else {
    echo 'Visita já registrada';
}