<?php

namespace App\Post\Domain\Event;

use App\Kernel\Domain\Event\DomainEvent;
use App\Kernel\Domain\Event\DomainEventSubscriber;

class SendEmailDomainEventSubscriber implements DomainEventSubscriber
{
    const ASYNCHRONOUS = false;

    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(DomainEvent $postWasMade)
    {
        $message = (new \Swift_Message('Post Created'))
            ->setFrom(getenv("EMAIL_ADMIN"))
            ->setTo(getenv("EMAIL_ADMIN"))
            ->setBody(
                '
                <html>
                    <head></head>
                    <body>
                    Post was made with title: '.$postWasMade->title().'. <br />
                    Post create at: '.$postWasMade->occurredOn()->format('Y-m-d H:i:s').' 
                    </body>
                </html>
                ',
                'text/html'
            );

        $this->mailer->send($message);
    }
}
