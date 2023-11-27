<?php

require_once 'AppController.php';

class DefaultController extends AppController{

    function panel_logowania(){
        $this->render('panel_logowania');
    }

    function panel_rejerstracji(){
        $this->render('panel_rejerstracji');
    }
}

 