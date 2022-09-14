<?php

require_once 'Model.php';

class Manager extends Model
{
    private string $tableName;
    private $entity;

    public function __construct(string $tableName, $entity, $lowerTableName = TRUE)
    {
        $this->tableName = $tableName;
        if($lowerTableName)
            $this->tableName = strtolower($this->tableName);
        $this->entity = $entity;
    }

    public function create(array $array): ?Entity
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

    public function update($id, $params): void
    {
        $sql = "UPDATE " . $this->tableName . " SET ";
        foreach ($params as $key => $val){
            $sql .= $key . " = ? , " ;
        }
        $sql = substr($sql, 0, -3);
        $sql .= " WHERE id = ?";

        $this->execRequest($sql, array_merge(array_values($params), array($id)));
    }

    public function delete($id) : void
    {
        $sql = "DELETE FROM " . $this->tableName . " WHERE id = ?";
        $this->execRequest($sql, array($id));
    }

    public function getByID($id): ?Entity
    {
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

    public function get(array $params, array $options = [], bool $asArray = true): array
    {
        $sql = "SELECT * FROM " . $this->tableName . " WHERE ";
        foreach ($params as $key => $val){
            $sql .= $key. " = ? AND ";
        }
        $sql = substr($sql, 0, -4);
        if(!empty($options)){
            if(isset($options['page'], $options['perPage']))
                $sql .= "LIMIT ".$options['perPage']*($options['page']-1).", ". ($options['perPage']);
        }
        return $this->execGetRequest($sql, $asArray, array_values($params));
    }

    public function getAll(array $options= [], bool $asArray = true): array
    {
        $sql = "SELECT * FROM " . $this->tableName . " ";
        if(!empty($options)){
            if(isset($options['page'], $options['perPage']))
                $sql .= "LIMIT ".$options['perPage']*($options['page']-1).", ". ($options['perPage']);
        }

        return $this->execGetRequest($sql, $asArray);
    }

    public function countAllRow(): int{
        $sql = "SELECT count(*) FROM " . $this->tableName . " ";
        $dbData = $this->execRequest($sql);
        return $dbData->fetch()[0];
    }

    private function execGetRequest(string $sql, bool $asArray = true, $params = []): array{
        $dbData = $this->execRequest($sql, $params);
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