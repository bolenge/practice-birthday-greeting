<?php

require_once './Message.php';

class MailMessage implements Message
{
    public function send(string $to, string $title, string $body): void
    {
        echo "Sending email to : " . $to . PHP_EOL;
        echo "Title: " . $title . PHP_EOL;
        echo "Body: Body\n" . $body . PHP_EOL;
        echo "-------------------------" . PHP_EOL;
    }
}
