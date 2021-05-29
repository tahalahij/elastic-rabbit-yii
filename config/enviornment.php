<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->safeLoad();

$env = [
    'rabbit_server_url' => $_ENV['R_SERVER_URL'],
    'rabbit_server_port' => $_ENV['R_SERVER_PORT'],
    'rabbit_username' => $_ENV['R_USERNAME'],
    'rabbit_password' => $_ENV['R_PASSWORD'],

    'es_base_url' => $_ENV['ES_BASE_URL'],
    'es_default_index' => $_ENV['ES_DEFAULT_INDEX']
];


return $env;
