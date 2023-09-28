<?php

namespace App\Models;

use Exception;
use Medoo\Medoo;

//https://medoo.in/api/new
class exampleModel
{
    public function __construct() {}

    public function exampleFunction($value)
    {
        try {
            $data = $database->select("exampleDatabase", "*");
            return $data ;
        } catch(Exception $exeption) {
            return 'error';
        }
    }
}
