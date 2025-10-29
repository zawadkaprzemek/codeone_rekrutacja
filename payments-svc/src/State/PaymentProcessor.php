<?php

declare(strict_types=1);

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Payment;
use App\Service\PaymentEventPublisher;

final class PaymentProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ProcessorInterface    $decorated,
        private readonly PaymentEventPublisher $publisher,
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $result = $this->decorated->process($data, $operation, $uriVariables, $context);

        if ($data instanceof Payment && $operation->getMethod() === 'POST') {
            $this->publisher->publishCreated($data);
        }

        return $result;
    }
}
