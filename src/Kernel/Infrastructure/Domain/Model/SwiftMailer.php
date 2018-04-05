<?php


namespace App\Kernel\Infrastructure\Domain\Model;

use App\Kernel\Domain\Model\Mailer;

class SwiftMailer implements Mailer
{

    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, string $to, string $subject, string $body) : int
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($from)
            ->setTo($to)
            ->setBody($body,
                'text/html'
            );

        return $this->mailer->send($message);
    }
}