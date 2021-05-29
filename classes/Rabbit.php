<?php

namespace app\classes;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbit
{
    
    public $server;
    public $port;
    public $username;
    public $password ;
    protected $queue;
    protected $connection;
    protected $channel;

    public function __construct($queue = 'azmoon')
    {
        $env = require __DIR__ . '/../config/enviornment.php';
        $this->queue = $queue;
        $this->server =  $env['rabbit_server_url'];
        $this->port = $env['rabbit_server_port'];
        $this->username = $env['rabbit_username'];
        $this->password = $env['rabbit_password'];

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
