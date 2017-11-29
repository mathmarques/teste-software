<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function indexAction(Request $request, Response $response, $args)
    {
        if ($request->isPost()) {
            
        }

        return $this->container->get('view')->render($response, 'confirmar.tpl');
    }

    public function confirmadoAction(Request $request, Response $response, $args)
    {
        $inputs = $request->getParsedBody();
        $inputs['time'] = time();

        $fileName = $this->container->get('settings')['jsons'] ."/". $inputs['matricula'] . $inputs['cpf'] . ".json";

        if(file_exists($fileName)) {
            $json_file = @file_get_contents($fileName);
            $json_str = json_decode($json_file, true);

            $inputs['older'] = $json_str;
        }

        if(!@file_put_contents($fileName, json_encode($inputs)))
            $this->container->get('view')['error'] = 'Erro ao salvar arquivo!';

        return $this->container->get('view')->render($response, 'confirmado.tpl');
    }


}