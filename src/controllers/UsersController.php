<?php

require_once 'models/UsersManager.php';
require_once 'helpers/JSON.php';

class UsersController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new UsersManager();
    }


    public function createUser($usersData): void{
        try{
            $userIDCreated = $this->manager->create($usersData);
            $userCreated = $this->manager->getByID($userIDCreated);
            JSON::setHeaders();
            JSON::sendData(array('user' => [
                "id" => $userCreated->getID(),
                "username" => $userCreated->getUsername(),
                "email" => $userCreated->getEmail(),
                "created" => $userCreated->getCreated()
            ]), 201);
        }catch (PDOException $PDOException){
            var_dump($PDOException);
            JSON::setHeaders();
            JSON::sendData(array('error' => "L'utilisateur ".$usersData["username"]." existe déjà" ), 400);
        }

    }

    public function getUsers($entityParams = [], $page = 1, $perPage = 10){
        if(empty($entityParams)){
            $users = $this->manager->getAll(true);
            $totalCount = count($users);


            JSON::setHeaders();
            JSON::sendData(array(
                'count' => $totalCount,
                'results' =>  $users
            ), 200);
        }
    }
}