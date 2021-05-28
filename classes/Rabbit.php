<?php

namespace app\classes;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbit {
    protected $server = 'localhost';
    protected $port = 5672;
    protected $username  = 'guest';
    protected $password  = 'guest';
    protected $queue;
    protected $connection;
    protected $channel;

    public function __construct($queue = 'azmoon')
    {
        $this->queue = $queue ;

        $this->connection = new AMQPStreamConnection($this->server, $this->port, $this->username, $this->password);

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, true, false, false, false);
    }

    public function send($msg)
    {
        $message = new AMQPMessage(json_encode($msg));

        $this->channel->basic_publish($message, '', $this->queue);
        return true;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}
