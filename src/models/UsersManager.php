<?php

require_once './framework/Manager.php';

class UsersManager extends Manager {

    public function __construct(){
        parent::__construct("Users", Users::class);
    }
    

}