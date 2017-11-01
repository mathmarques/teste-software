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
            if($json_file = @file_get_contents("http://integra.ice.ufjf.br:8080/evento/97")) {
                $json_str = json_decode($json_file, true);
                $matricula = $request->getParsedBodyParam('matricula');
                $atividades = [];
                if(!empty($matricula)) {
                    for ($i = 0; $i < count($json_str); $i++) {
                        if ((strcmp($json_str[$i]['maricula'], $matricula) == 0) || (strcmp($json_str[$i]['cpf'], $matricula) == 0)) {
                            $json_str[$i]['confirmado'] = true;
                            $atividades[] = $json_str[$i];
                        }
                    }
                }
                if(count($atividades) > 0) {
                    $fileName = $this->container->get('settings')['jsons'] ."/". $atividades[0]['maricula'] . $atividades[0]['cpf'] . ".json";
                    if(file_exists($fileName)){
                        $json_file = @file_get_contents($fileName);
                        $json_str = json_decode($json_file, true);

                        for($i = 0; $i < count($atividades); $i++) {
                            if( in_array($atividades[$i]['idAtividade'], $json_str['atividades']) ) {
                                $atividades[$i]['confirmado'] = true;
                            } else
                                $atividades[$i]['confirmado'] = false;
                        }
                    }
                    $this->container->get('view')['atividades'] = $atividades;
                } else
                    $this->container->get('view')['error'] = 'Não existe inscrições com essa Matrícula/CPF!';
            } else
                $this->container->get('view')['error'] = 'Erro ao comunicar com integra!';

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