<?php

require_once 'helpers/JSON.php';

class MainController{

    public function __construct(){

    }

    public function noRoutesFound(){
        JSON::setHeaders();
        JSON::sendData(array('error' => 'No routes found'), 404);
    }



}