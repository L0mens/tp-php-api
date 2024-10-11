<?php

class JSON{

    public static function setHeaders(){
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Credentials:true");
        header("Access-Control-Max-Age: 100000");
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
        header("Access-Control-Allow-Methods: PUT, POST, GET, OPTIONS, DELETE");
    }

    public static function sendData($data, $httpCode){
        $json = json_encode($data);
        if ($json === false) {
            // Avoid echo of empty string (which is invalid JSON), and
            // JSONify the error message instead:
            $json = json_encode(["error" => json_last_error_msg()]);
            if ($json === false) {
                // This should not happen, but we go all the way now:
                $json = '{"error":"jsonError unknown"}';
            }
            // Set HTTP response status code to: 500 - Internal Server Error
            http_response_code(500);
        }
        http_response_code($httpCode);
        echo $json;
    }

    public static function sendNoContent204(){
        http_response_code(204);
    }

}