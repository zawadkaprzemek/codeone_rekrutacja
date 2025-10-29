<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\PaymentCreatedMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class PaymentCreatedMessageHandler
{
    public function __invoke(PaymentCreatedMessage $message): void
    {
        file_put_contents(
            __DIR__ . '/../../var/log/payments.log',
            json_encode($message, JSON_THROW_ON_ERROR) . PHP_EOL,
            FILE_APPEND
        );
    }
}
