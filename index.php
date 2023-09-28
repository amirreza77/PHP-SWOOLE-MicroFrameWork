<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';
$dotenv = new DotEnv(__DIR__);
$dotenv->load();


$swoolhost = getenv('SWOOLEHOST');
$swoolhostname = getenv('SWOOLEHOSTNAME');
$swoolport = getenv('SWOOLEPORT');


include_once("config.php");
include_once("dbConfig.php");
include_once("router/api.php");
