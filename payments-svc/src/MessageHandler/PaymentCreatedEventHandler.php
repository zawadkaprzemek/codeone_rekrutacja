<?php

namespace App\MessageHandler;

use App\Message\PaymentCreatedEvent;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PaymentCreatedEventHandler
{
    public function __invoke(PaymentCreatedEvent $event)
    {
        file_put_contents(__DIR__.'/../../var/log/payments.log', json_encode($event).PHP_EOL, FILE_APPEND);
    }
}
