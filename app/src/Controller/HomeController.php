<?php

namespace App\Controller;

use App\Library\UnitProcessor;
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
        if(isset($_SESSION['id'])) {
            $unitProcessor = new UnitProcessor($this->container->get('settings')['phpunit'], $_SESSION['id']);
            $files = $unitProcessor->getUserCode();
            $this->container->get('view')['code'] = $files['main'];
            $this->container->get('view')['testCode'] = $files['test'];
        } else {
            $this->container->get('view')['code'] = <<<'CODE'
<?php

class Main {

	public function exemplo($var) {
		if($var)
			return 2;
		else
			return 1;
	}

}
CODE;

            $this->container->get('view')['testCode'] = <<<'CODE'
<?php
use PHPUnit\Framework\TestCase;

require('Main.php'); //Não remova isto

class MainTest extends TestCase
{
    public function testExemplo()
    {
        $teste = new Main(); //Nome da Classe

        $this->assertEquals(1, $teste->exemplo(false));
    }

}

CODE;
        }
        return $this->container->get('view')->render($response, 'home.tpl');
    }

}