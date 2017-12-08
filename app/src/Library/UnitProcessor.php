<?php

namespace App\Library;
class UnitProcessor
{
    private $identifier;
    private $settings;
    private $userFolder;

    public function __construct($settings, $identifier)
    {
        $this->settings = $settings;
        $this->identifier = $identifier;
        $this->userFolder = $this->settings['unitFolder'].$identifier.'/';
    }

    public function generateFiles($code, $testCode)
    {
        if(!is_dir($this->userFolder))
            mkdir($this->userFolder);

        copy ( $this->settings['unitFolder'].'phpunit.xml.dist' ,  $this->userFolder.'phpunit.xml.dist');
        file_put_contents($this->userFolder.'Main.php', $code);
        file_put_contents($this->userFolder.'MainTest.php', $testCode);
    }

    public function execute()
    {
        $cmd = "export PATH=/Applications/MAMP/bin/php/php7.1.1/bin:\$PATH && cd " . $this->userFolder . " && " . $this->settings['phpunit'] . " 2>&1";
        $output = shell_exec($cmd);

        $clover = [];

        if (is_null($output) || empty($output))
            $output = 'ERRO! Seu código contém erros!';
        else {
            $xmlObj = simplexml_load_file($this->userFolder . 'clover.xml');
            if (isset($xmlObj->project->file)) {
                $lines = [];
                $mainFile = $xmlObj->project->file[0];
                foreach ($mainFile as $key => $value) {
                    $lines[] = $value;
                }

                array_shift($lines);
                array_pop($lines);

                foreach ($lines as $key => $value) {
                    $clover[''.$value->attributes()['num']] = (string)$value->attributes()['count'];
                }
            }
        }

        return ['output' => $output, 'clover' => $clover, 'XMLClover' => $xmlObj];
    }

    public function getUserCode()
    {

        $mainCode = file_get_contents($this->userFolder.'Main.php');
        $testCode = file_get_contents($this->userFolder.'MainTest.php');

        return ['main' => $mainCode, 'test' => $testCode];
    }
}