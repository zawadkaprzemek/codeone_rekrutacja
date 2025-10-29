<?php

declare(strict_types=1);

namespace App\DataPersister;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Payment;
use App\Service\PaymentEventPublisher;

final readonly class PaymentDataPersister implements ProcessorInterface
{
    public function __construct(
        private ProcessorInterface    $decorated,
        private PaymentEventPublisher $publisher
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $result = $this->decorated->process($data, $operation);

        if ($data instanceof Payment && ($context['collection_operation_name'] ?? null) === 'post') {
            $this->publisher->publishCreated($data);
        }

        return $result;
    }
}
