<?php
require __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
$channel = $connection->channel();
$channel->queue_declare('payment.created', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = static function ($msg) {
    $log = sprintf("[%s] Payment event: %s\n", date('c'), $msg->body);
    echo $log;
    file_put_contents('/app/notifications.log', $log, FILE_APPEND);
};

$channel->basic_consume('payment.created', '', false, true, false, false, $callback);

while ($channel->is_open()) {
    $channel->wait();
}
