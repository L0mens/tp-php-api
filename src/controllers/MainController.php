<?php

require_once 'framework/JSON.php';

class MainController{

    public function __construct(){

    }

    public function noRoutesFound(){
        JSON::setHeaders();
        JSON::sendData(array('error' => 'No routes found'), 404);
    }

    public function errorParameters($message){
        JSON::setHeaders();
        JSON::sendData(array('error' => $message), 400);
    }



}