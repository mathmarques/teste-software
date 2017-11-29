<?php

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class RelatorioController
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function indexAction(Request $request, Response $response, $args)
    {

        $this->container->get('view')['pessoasTotais'] = 0;
        $this->container->get('view')['atividades'] = array();
        $this->container->get('view')['emails'] = array();

        return $this->container->get('view')->render($response, 'relatorio.tpl');
    }

    public function detalheAction(Request $request, Response $response, $args)
    {

    return $this->container->get('view')->render($response, '404.tpl');
    }


}