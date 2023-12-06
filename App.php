<?php
require_once './SMSMessage.php';
require_once './Greeting.php';

class App
{
    public function run(string $fileName)
    {
        $message = new SMSMessage();

        (new Greeting($message))->wish($fileName);
    }
}

(new App())->run(__DIR__ . DIRECTORY_SEPARATOR . 'employees.txt');
