<?php

require_once 'AppController.php';
require_once __DIR__ .'/../models/User.php';

class SecurityController extends AppController {

    public function panel_logowania()
    {
        /*
        $users = [
            new User('alice@example.com', 'user', '777111222', 'Johnson'),
            new User('bob@example.com', 'admin', '555555555', 'Smith'),
            new User('charlie@example.com', 'user', '666666666', 'Brown'),
            new User('diana@example.com', 'admin', '444555666', 'Williams'),
            new User('edward@example.com', 'user', '111222333', 'Miller'),
        ];
        */

        $user = new User('jsnow@pk.edu.pl', 'admin', 'Johnny', 'Snow');

        if (!$this->isPost()) {
            return $this->render('panel_logowania');
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($user->getEmail() !== $email) {
            return $this->render('panel_logowania', ['messages' => ['User with this email not exist!']]);
        }

        if ($user->getPassword() !== $password) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/panel_glowny");
    }


}