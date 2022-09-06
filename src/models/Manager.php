<?php

require_once 'Model.php';

class Manager extends Model
{

    private $tableName;
    private $entity;

    public function __construct($tableName, $entity)
    {
        $this->tableName = $tableName;
        $this->entity = $entity;
    }

    public function create(array $array)
    {
        $val = implode(",", array_fill(0, count($array), '?'));
        $sql = "INSERT INTO " . $this->tableName . " (" . implode(",", array_keys($array)) . ") VALUES (" . $val . ")";
        $sqlLastID = "SELECT LAST_INSERT_ID()";
        $this->execRequest($sql, array_values($array));
        $getId = $this->execRequest($sqlLastID);
        if ($id = $getId->fetch())
            return $id[0];
        else
            return null;
    }

    public function update($entity)
    {

    }

    public function delete($entity)
    {

    }

    public function getByID($id)
    {
        var_dump($id);
        $sql = "SELECT * FROM " . $this->tableName . " WHERE id = ?";
        $dbData = $this->execRequest($sql, array($id));
        if ($dbData->rowCount() > 0) {
            $data = $dbData->fetch();
            $model = new $this->entity($data);
            return $model;
        } else {
            return null;
        }
    }

    public function get($params)
    {
        $val = implode(",", array_fill(0, count($params), '?'));
        $sql = "SELECT * FROM " . $this->tableName . " (" . implode(",", array_keys($params)) . ") VALUES (" . $val . ")";
    }

    public function getAll(bool $asArray = true)
    {
        $sql = "SELECT * FROM " . $this->tableName . " ";
        $dbData = $this->execRequest($sql);
        $all_users = [];
        while ($user = $dbData->fetch()) {

            if ($asArray) {
                foreach ($user as $key => $value) {
                    if (is_numeric($key)) {
                        unset($user[$key]);
                    }
                }
                $all_users[] = $user;

            } else{
                $t = new $this->entity($user);
                $all_users[] = $t;
            }

        }
        return $all_users;
    }
}