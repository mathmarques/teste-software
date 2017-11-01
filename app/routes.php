<?php

// Routes
$app->map(['GET', 'POST'], '/', '\App\Controller\HomeController:indexAction')->setName('confirmar');
$app->post('/confirmado', '\App\Controller\HomeController:confirmadoAction')->setName('confirmado');

$app->get('/relatorio', '\App\Controller\RelatorioController:indexAction')->setName('relatorio');
$app->get('/relatorio/{id}', '\App\Controller\RelatorioController:detalheAction')->setName('relatorioDetalhe');
$app->get('/confirmados', '\App\Controller\RelatorioController:relatorioConfirmadoAction')->setName('relatorioConfirmado');
