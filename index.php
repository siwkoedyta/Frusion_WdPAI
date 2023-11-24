<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Routing::get('panel_logowania', 'DefaultController');
Routing::post('panel_logowania', 'SecurityController');

Routing::get('panel_rejerstracji', 'DefaultController');
Routing::post('panel_rejerstracji', 'SecurityController');

Routing::get('panel_klienta', 'DefaultController');
Routing::get('panel_glowny', 'DefaultController');
Routing::get('add_client', 'DefaultController');
Routing::get('boxes', 'DefaultController');
Routing::get('fruit_list', 'DefaultController');
Routing::get('status_frusion', 'DefaultController');

Routing::get('FileNotFound', 'ErrorController');
Routing::post('wyloguj', 'SecurityController');


Routing::run($path);



