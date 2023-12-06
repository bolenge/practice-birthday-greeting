<?php

interface Message
{
    public function send(string $to, string $title, string $body): void;
}
