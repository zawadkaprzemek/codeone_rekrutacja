<?php

namespace App\Service;

use App\Entity\Payment;
use App\Message\PaymentCreatedMessage;
use Symfony\Component\Messenger\MessageBusInterface;

class PaymentEventPublisher
{
    public function __construct(private MessageBusInterface $bus) {}

    public function publishCreated(Payment $payment): void
    {
        $this->bus->dispatch(new PaymentCreatedMessage($payment->getId(), $payment->getAmount()));
    }
}
