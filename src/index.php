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
function getParam(array $array, string $paramName, bool $canBeEmpty=true, $defaultValueIfAbsent=null)
{
    if (isset($array[$paramName])) {
        if(!$canBeEmpty && empty($array[$paramName]))
            throw new Exception("Paramètre '$paramName' vide");
        return $array[$paramName];
    }
    else
    {

        if(!isset($defaultValueIfAbsent))
            throw new Exception("Paramètre '$paramName' absent");
        else
            return $defaultValueIfAbsent;
    }

}

if (isset($_GET['service'])) {
    if ($_GET['service'] == "users") {
        if($_SERVER['REQUEST_METHOD'] == 'GET'){
            try{
                $searchParams = [
                    "username" => getParam($_GET, 'username', false, ""),
                    "email" => getParam($_GET, 'email', false, "")
                ];
                // Remove empty keys
                $searchParams = array_filter($searchParams);
                $page = getParam($_GET, 'page', false, 1);
                $perPage = getParam($_GET, 'perPage', false, 3);
                if(is_numeric($page))
                    $page = intval($page);
                else
                    throw new TypeError("Le paramètre page n'est pas un entier");
                if(is_numeric($perPage))
                    $perPage = intval($perPage);
                else
                    throw new TypeError("Le paramètre perPage n'est pas un entier");
                $usersCtrl->getUsers($searchParams, $page, $perPage);
            }catch (Exception $exception){
                $ctrl->errorParameters($exception->getMessage());
            }
            catch (Error $exception){
                $ctrl->errorParameters($exception->getMessage());
            }

        }
        else if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            $usersdata = [
                "username" => $_POST['username'],
                "email" => $_POST['email'],
            ];
            $usersCtrl->createUser($usersdata);
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'PUT'){
            //Retrieve PUT DATA and send them to $post_vars
            parse_str(file_get_contents("php://input"),$post_vars);
            try{
                $idUser = getParam($_GET, 'iduser', false);
                $searchParams = [
                    "username" => getParam($post_vars, 'username', false, ""),
                    "email" => getParam($post_vars, 'email', false, "")
                ];
                $usersCtrl->updateUsers($idUser, $searchParams);
            }
            catch (Exception $exception){
                $ctrl->errorParameters($exception->getMessage());
            }
        }
        else if ($_SERVER['REQUEST_METHOD'] == 'DELETE'){
            try{
                $idUser = getParam($_GET, 'iduser', false);
                $usersCtrl->deleteUsers($idUser);
            }
            catch (Exception $exception){
                $ctrl->errorParameters($exception->getMessage());
            }

        }
        else{
            $ctrl->noRoutesFound();
        }

    } else {
        $ctrl->noRoutesFound();
    }
} else {
    $ctrl->noRoutesFound();
}

