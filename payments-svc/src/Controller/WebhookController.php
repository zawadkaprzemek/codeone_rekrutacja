<?php

declare(strict_types=1);

namespace App\Controller;

use App\Message\PaymentCreatedEvent;
use App\Repository\PaymentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class WebhookController extends AbstractController
{
    public function __construct(
        private readonly PaymentRepository $payments,
        private readonly MessageBusInterface $bus
    ) {}

    #[Route('/api/webhooks/tpay', name: 'tpay_webhook', methods: ['POST'])]
    public function tpayWebhook(Request $request): Response
    {
        $data = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $payment = $this->payments->find($data['payment_id'] ?? 0);
        if (!$payment) {
            return new Response('Payment not found', 404);
        }

        $payment->setStatus($data['status'] ?? 'unknown');

        $this->bus->dispatch(new PaymentCreatedEvent($payment->getId(), $payment->getAmount()));

        return new Response('OK', 200);
    }
}
