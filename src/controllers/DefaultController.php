<?php

require_once 'AppController.php';

class DefaultController extends AppController{

    function panel_logowania(){
        $this->render('panel_logowania');
    }

    function panel_rejerstracji(){
        $this->render('panel_rejerstracji');
    }

    function panel_klienta(){
        $this->render('panel_klienta');
    }

    function panel_glowny(){
        $this->render('panel_glowny');
    }

    function add_client(){
        $this->render('add_client');
    }

    function boxes(){
        $this->render('boxes');
    }

    function fruit_list(){
        $this->render('fruit_list');
    }

    function status_frusion(){
        $this->render('status_frusion');
    }
}

 