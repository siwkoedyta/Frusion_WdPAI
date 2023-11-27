<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url( $path, PHP_URL_PATH);

Routing::get('panel_logowania', 'DefaultController');
Routing::post('panel_logowania', 'SecurityController');

Routing::get('panel_rejerstracji', 'DefaultController');
Routing::post('panel_rejerstracji', 'SecurityController');

Routing::get('panel_klienta', 'SecurityController');
Routing::get('panel_glowny', 'SecurityController');
Routing::get('add_client', 'SecurityController');
Routing::get('boxes', 'SecurityController');
Routing::get('fruit_list', 'SecurityController');
Routing::get('status_frusion', 'SecurityController');

Routing::get('FileNotFound', 'ErrorController');
Routing::post('wyloguj', 'SecurityController');


Routing::run($path);



