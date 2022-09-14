<?php

class JSON{

    public static function setHeaders(){
        header("Content-Type: application/json");
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