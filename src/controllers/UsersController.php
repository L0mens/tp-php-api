<?php

require_once 'models/UsersManager.php';
require_once 'framework/JSON.php';

class UsersController
{
    private $manager;

    public function __construct()
    {
        $this->manager = new UsersManager();
    }


    public function createUser($usersData): void{
        try{
            JSON::setHeaders();
            $userIDCreated = $this->manager->create($usersData);
            $userCreated = $this->manager->getByID($userIDCreated);
            JSON::sendData(array('user' => [
                "id" => $userCreated->getID(),
                "username" => $userCreated->getUsername(),
                "email" => $userCreated->getEmail(),
                "created" => $userCreated->getCreated()
            ]), 201);
        }catch (PDOException $PDOException){
            JSON::sendData(array('error' => "L'utilisateur ".$usersData["username"]." existe déjà" ), 400);
        }

    }

    public function getUsers($entityParams = [], $page = 1, $perPage = 10){
        JSON::setHeaders();
        if(empty($entityParams)){
            $users = $this->manager->getAll(["page"=> $page, "perPage" => $perPage],true);
            $totalCount = $this->manager->countAllRow();

            JSON::sendData(array(
                'count' => $totalCount,
                'page' => $page,
                'perPage' => $perPage,
                'results' =>  $users
            ), 200);
        }
        else{
            $users = $this->manager->get($entityParams, ["page"=> $page, "perPage" => $perPage]);

            if (count($users) > 0)
                $status = 200;
            else
                $status = 404;

            JSON::sendData(array(
                'params' => $entityParams,
                'page' => $page,
                'perPage' => $perPage,
                'results' =>  $users
            ), $status);

        }
    }

    public function deleteUsers($idUser){
        JSON::setHeaders();
        $this->manager->delete($idUser);
        JSON::sendNoContent204();
    }

    public function updateUsers($idUser, $userParams){
        JSON::setHeaders();
        $user = $this->manager->getByID($idUser);
        if(empty($user)){
            JSON::sendData(array('error' => "L'id utilisateur ".$idUser." n'existe pas" ), 404);
        }
        else{
            if(isset($userParams['username'],$userParams['email'])){
                try{
                    $this->manager->update($idUser, $userParams);
                    JSON::sendNoContent204();
                }
                catch (Exception $exception){
                    JSON::sendData(array('error' => $exception->getMessage() ), 400);
                }

            }
        }
    }
}