<?php

// Routes
$app->get('/', '\App\Controller\HomeController:indexAction')->setName('home');


$app->post('/api/process', '\App\Controller\APIController:processAction')->setName('apiProcess');