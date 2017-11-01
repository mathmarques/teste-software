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

    private function getActivities()
    {
        $atividadesCacheFile = $this->container->get('settings')['atividadesCache'];
        $atividades = [];
        if(file_exists($atividadesCacheFile)) {
            $json_file = @file_get_contents($atividadesCacheFile);
            $atividades = json_decode($json_file, true);
        }

        $jsonsDir = $fileName = $this->container->get('settings')['jsons'] ."/";

        $confirmacoes = [];
        $dirFiles = @scandir($jsonsDir);
        $quantPessoas = 0;
        foreach ($dirFiles as $key => $file) {
            if(strpos($file, '.json')) {
                $json_file = @file_get_contents($jsonsDir.$file);
                $pessoa = json_decode($json_file, true);
                foreach ($pessoa['atividades'] as $ativId) {
                    if(!isset($confirmacoes[$ativId]))
                        $confirmacoes[$ativId] = [];
                    $confirmacoes[$ativId][] = ['nome_pessoa'=> $pessoa['nome_pessoa'], 'matricula'=> $pessoa['matricula'], 'cpf'=> $pessoa['cpf'], 'time'=> $pessoa['time']];
                }

                $quantPessoas++;
            }
        }

        $alwaysUpdate = true;
        $emails = [];
        //Check if we need to update our activities cache
        foreach ($confirmacoes as $ativId => $inscritos) {
            if(!isset($atividades[$ativId]) || $alwaysUpdate) {
                $atividades = [];
                if($json_file = @file_get_contents("http://integra.ice.ufjf.br:8080/evento/97")) {
                    $json_str = json_decode($json_file, true);

                    for ($i = 0; $i < count($json_str); $i++) {
                        if(!isset($atividades[$json_str[$i]['idAtividade']])) {
                            $atividades[$json_str[$i]['idAtividade']] = ['idAtividade' => $json_str[$i]['idAtividade'], 'atividade' => $json_str[$i]['atividade'], 'inscritos'=> 1];
                            $atividades[$json_str[$i]['idAtividade']]['confirmados'] = [];
                        } else
                            $atividades[$json_str[$i]['idAtividade']]['inscritos']++;

                        if(empty($json_str[$i]['maricula'])) {
                            $emails[$json_str[$i]['cpf']] = $json_str[$i]['email'];
                        } else {
                            $emails[$json_str[$i]['maricula']] = $json_str[$i]['email'];
                        }
                    }

                    file_put_contents($atividadesCacheFile, json_encode($atividades));
                } else
                    return [];

                break;
            }
        }

        foreach ($confirmacoes as $ativId => $inscritos) {
            $atividades[$ativId]['confirmados'] = $inscritos;
        }

        return ['pessoasTotais' => $quantPessoas, 'atividades'=> $atividades, 'emails' => $emails];
    }

    public function indexAction(Request $request, Response $response, $args)
    {
        $relatorio = $this->getActivities();

        $this->container->get('view')['pessoasTotais'] = $relatorio['pessoasTotais'];
        $this->container->get('view')['atividades'] = $relatorio['atividades'];
        $this->container->get('view')['emails'] = $relatorio['emails'];

        return $this->container->get('view')->render($response, 'relatorio.tpl');
    }

    public function detalheAction(Request $request, Response $response, $args)
    {
        $relatorio = $this->getActivities();

        if(isset($relatorio['atividades'][$args['id']])) {
            $atividade = $relatorio['atividades'][$args['id']];

            usort($atividade['confirmados'], function ($a, $b){
                return $b['time'] < $a['time'];
            });

            $this->container->get('view')['atividade'] = $atividade;
            $this->container->get('view')['emails'] = $relatorio['emails'];

            return $this->container->get('view')->render($response, 'relatorioDetalhe.tpl');
        } else {
            return $this->container->get('view')->render($response, '404.tpl');
        }
    }

    public function relatorioConfirmadoAction(Request $request, Response $response, $args)
    {
        $relatorio = $this->getActivities();

        $pessoas = [];
        $jsonsDir = $fileName = $this->container->get('settings')['jsons'] ."/";
        $dirFiles = @scandir($jsonsDir);
        foreach ($dirFiles as $key => $file) {
            if(strpos($file, '.json')) {
                $json_file = @file_get_contents($jsonsDir.$file);
                $pessoa = json_decode($json_file, true);
                $pessoas[] = $pessoa;
            }
        }

        usort($pessoas, function ($a, $b){
            if(empty($a['matricula'])) {
                $identA = $a['cpf'];
            } else {
                $identA = $a['matricula'];
            }

            if(empty($b['matricula'])) {
                $identB = $b['cpf'];
            } else {
                $identB = $b['matricula'];
            }

            return $identB < $identA;
        });

        $this->container->get('view')['pessoas'] = $pessoas;
        $this->container->get('view')['emails'] = $relatorio['emails'];

        return $this->container->get('view')->render($response, 'relatorioConfirmado.tpl');
    }


}