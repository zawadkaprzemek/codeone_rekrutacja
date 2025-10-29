<?php

declare(strict_types=1);

namespace App\Message;

class PaymentCreatedMessage
{
    public function __construct(
        public int $id,
        public string $amount
    ) {}
}
