<?php

namespace App\Post\Domain\Event;

use App\Kernel\Domain\Event\DomainEvent;
use App\Kernel\Domain\Event\DomainEventSubscriber;
use App\Kernel\Domain\Model\Mailer;
use App\Post\Domain\Model\PostWasMade;

class SendEmailDomainEventSubscriber implements DomainEventSubscriber
{
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function handle(DomainEvent $postWasMade)
    {
        if (!($postWasMade instanceof PostWasMade)) {
            throw new \Exception("Error type object in SendEmailDomainEventSubscriber.");
        }

        $body = '<html>
                <head></head>
                <body>
                Post was made with title: '.$postWasMade->title().'. <br />
                Post create at: '.$postWasMade->occurredOn()->format('Y-m-d H:i:s').' 
                </body>
            </html>
        ';

        $this->mailer->send(
            getenv("EMAIL_ADMIN"),
            getenv("EMAIL_ADMIN"),
            'Post Created',
            $body
        );
    }
}
