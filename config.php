<?php
define('APP_ROOT', dirname(__FILE__));
define('URL_ROOT', '/');
define('URL_SUBFOLDER', '');

// swoole server setup
$serversetup = [
    'pid_file' =>  APP_ROOT . '/storage/logs/swoole_http.pid',
    'log_file' => APP_ROOT . '/storage/logs/swoole_http.txt',
    'daemonize' =>  false,
    // Normally this value should be 1~4 times larger according to your cpu cores.
    'reactor_num' => 8,
    'worker_num' => 4,
    'task_worker_num' => 8,
    'task_enable_coroutine' => true,
    'task_use_object' => true,
    // The data to receive can't be larger than buffer_output_size.
    'package_max_length' => 20 * 1024 * 1024,
    // The data to send can't be larger than buffer_output_size.
    'buffer_output_size' => 10 * 1024 * 1024,
    // Max buffer size for socket connections
    'socket_buffer_size' => 128 * 1024 * 1024,
    // Worker will restart after processing this number of requests
    'max_request' => 3000,
    // Enable coroutine send
    'send_yield' => true,
    // You must add --enable-openssl while compiling Swoole
    'ssl_cert_file' => null,
    'ssl_key_file' => null,
];
define('SERVER_SET_UP', $serversetup);
