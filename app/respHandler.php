<?php
namespace app;

class respHandler
{

    public function success_response($data, $code, $msg, $total =0)
    {

        try {
            return [
                'status' => 200,
                'message' => $msg,
                'total' => $total,
                'data' => $data,
                'Operation Code' => $code,
            ];
        } catch (Exeption $e) {
            return [
                'status' => 400,
                'message' => 'response handler error',
                // 'error' => $e,
                'Operation Code' => 122,
            ];
        }
    }

    public function error_response($error, $code, $msg)
    {

        try {
            return [
                'status' => 400,
                'message' => $msg,
                'error' => $error,
                'Operation Code' => $code,
            ];
        } catch (Exeption $e) {
            return [
                'status' => 400,
                'message' => 'response handler error',
                // 'error' => $e,
                'Operation Code' => 122,
            ];
        }
    }
}