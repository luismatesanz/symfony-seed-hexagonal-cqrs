<?php


namespace App\Kernel\Domain\Model;


interface Mailer
{
    public function send(string $from, string $to, string $subject, string $body) : int;
}