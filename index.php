<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Routing::get('panel_logowania', 'DefaultController');
Routing::post('panel_logowania', 'SecurityController');

Routing::get('panel_rejerstracji', 'DefaultController');
Routing::post('panel_rejerstracji', 'SecurityController');

Routing::get('panel_klienta', 'SecurityController');

Routing::get('change_password', 'ChangePasswordController');
Routing::post('change_password_form', 'ChangePasswordController');

Routing::get('panel_glowny', 'SecurityController');

Routing::get('add_client', 'AddClientController');
Routing::post('add_client_form', 'AddClientController');

Routing::get('boxes', 'BoxController');
Routing::post('boxes', 'BoxController');

Routing::get('fruit_list', 'FruitController');
Routing::post('fruit_list', 'FruitController');

Routing::get('status_frusion', 'SecurityController');

Routing::get('FileNotFound', 'ErrorController');
Routing::post('wyloguj', 'SecurityController');


Routing::run($path);



