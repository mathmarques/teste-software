<?php
use PHPUnit\Framework\TestCase;

require('Main.php');

class MainTest extends TestCase
{
    public function testeUm()
    {
        $teste = new Main();

        $this->assertEquals(1, $teste->teste(false));
    }
}
