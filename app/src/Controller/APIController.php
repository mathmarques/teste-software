<?php

namespace App\Controller;

use App\Library\UnitProcessor;
use Interop\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class APIController
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function processAction(Request $request, Response $response, $args)
    {
        if(!isset($_SESSION['id']))
            $_SESSION['id'] = mt_rand ( 1 , 120980 );

        $json = [];

        $inputs = $request->getParsedBody();

        $unitProcessor = new UnitProcessor($this->container->get('settings')['phpunit'], $_SESSION['id']);
        $unitProcessor->generateFiles($inputs['code'], $inputs['testCode']);

        $json['phpunit'] = $unitProcessor->execute();

        return $response->withJson($json);
    }


}