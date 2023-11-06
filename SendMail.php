<?php

class SendMail
{
    public static function send(string $to, string $title, string $body)
    {
        echo "Sending email to : " . $to . PHP_EOL;
        echo "Title: " . $title . PHP_EOL;
        echo "Body: Body\n" . $body . PHP_EOL;
        echo "-------------------------" . PHP_EOL;
    }
}
