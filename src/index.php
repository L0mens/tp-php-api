<?php
declare(strict_types=1);
require_once './controllers/MainController.php';
require_once './controllers/UsersController.php';

require_once './models/Users.php';


$ctrl = new MainController();
$usersCtrl = new UsersController();

/**
 * @throws Exception
 */
function getParam(array $array, string $paramName, bool $canBeEmpty=true)
{
    if (isset($array[$paramName])) {
        if(!$canBeEmpty && empty($array[$paramName]))
            throw new Exception("Paramètre '$paramName' vide");
        return $array[$paramName];
    } else
        throw new Exception("Paramètre '$paramName' absent");
}

if (isset($_GET['service'])) {
    if ($_GET['service'] == "users") {
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            $usersCtrl->getUsers();
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $usersdata = [
                "username" => $_POST['username'],
                "email" => $_POST['email'],
            ];
            $usersCtrl->createUser($usersdata);
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'PUT'){

        }
        else if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){

        }
        else{
            $ctrl->noRoutesFound();
        }

    } else if ($_GET['service'] == "edit-animal") {
       

    } else if ($_GET['service'] == "del-animal") {
        
    } else if ($_GET['service'] == "search") {
        
    } else if ($_GET['service'] == "add-proprietaire") {
        
    } else {
        $ctrl->noRoutesFound();
    }
} else {
    $ctrl->noRoutesFound();
}


