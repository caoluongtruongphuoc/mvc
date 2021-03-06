<?php

namespace App\Core;

use App\Config\Database;
use App\Core\Model;
use PDO;

class ResourceModel implements ResourceModelInterface
{
    private $table;
    private $id;
    private $model;

    //override 
    public function _init($table, $id, $model) 
    {
        $this->table = $table;
        $this->id = $id;
        $this->model = $model;
    }

    //override
    public function save($model) 
    {
        //get properties, ko get đc nếu các thuộc tính là private nên để là protected
        $properties = $model->getProperties();
        
        var_dump($properties);
        //camelCase sang under_score
        $callBack = function ($a) {
            return "_" . $a[0];
        };

        $pattern = "/[A-Z]/";
        foreach ($properties as $oldKey => $value) {
            $newKey = strtolower(
                preg_replace_callback(
                    $pattern,
                    $callBack,
                    $oldKey
                )
            );
            $properties[$newKey] = $properties[$oldKey];

            // nếu $oldKey có chữ viết hoa thì xóa
            if (preg_match($pattern, $oldKey)) {
                unset($properties[$oldKey]);
            }         
        }

        // ví dụ :id hay :name 
        $insertEle = [];

        // ví dụ id = :id hay name = :name
        $updateEle = [];

        foreach ($properties as $key => $value) {
            array_push($insertEle, ":" . $key);
            array_push($updateEle, $key . " = :" . $key);
        }

        // hợp mảng insertEle và updateEle thành chuỗi
        $insertString = implode(", ", $insertEle);
        $updateString = implode(", ", $updateEle);

        // nếu có id thì update nếu chưa thì thêm
        if ($model->getId() == null) {
            $sql= "INSERT INTO $this->table VALUES ($insertString, :created_at, :updated_at)";
            $req = Database::getBdd()->prepare($sql);

            // thời gian
            $date = [];
            $date["created_at"] = date('Y-m-d H:i:s');
            $date["updated_at"] = date('Y-m-d H:i:s');

            // hợp 2 mảng thuộc tính vs date
            $arrayMerge = array_merge($properties, $date);

            // cần phải chỉnh thứ tự cột trong mysql sao cho tương ứng trong model
            return $req->execute($arrayMerge);
        } else {
            $sql = "UPDATE $this->table SET $updateString, updated_at = :updated_at WHERE id = :id";
            $req = Database::getBdd()->prepare($sql);

            // thời gian
            $date = [];
            $date["updated_at"] = date('Y-m-d H:i:s');

            // hợp 2 mảng thuộc tính vs date
            $arrayMerge = array_merge($properties, $date);

            return $req->execute($arrayMerge);
        }   
    }

    //override 
    public function delete($model) 
    {
        $sql = "DELETE FROM $this->table WHERE id = $model->id";
        $req = Database::getBdd()->prepare($sql);

        return $req->execute();
    }

    public function getById($id) 
    {
        $class = get_class($this->model);
        $sql = "SELECT * FROM $this->table WHERE id = $id";
        $req = Database::getBdd()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute();

        return $req->fetch();
    }

    public function getAll() 
    {
        $sql = "SELECT * FROM $this->table";
        $req = Database::getBdd()->prepare($sql);
        $req->setFetchMode(PDO::FETCH_OBJ);
        $req->execute();

        return $req->fetchAll();
    }
}
