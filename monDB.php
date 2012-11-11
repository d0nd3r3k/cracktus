<?php

/*
 * MongoDB class
 * author: Donald Derek
 * Last Update: 11/8/2012@8:33PM
 */

class monDB {

    private $db_name = "cracktus";
    private $database;

    function __construct() {
        $mongoDB = new Mongo();
        $this->database = $mongoDB->selectDB($this->db_name);
    }

    public function insert($collection_name, $json) {

        $collection = $this->database->createCollection($collection_name);
        $data = json_decode($json);
        $collection->insert($data);

        return $data;
    }
    
    public function get($collection_name) {
        $collection = $this->database->createCollection($collection_name);
        $retrieved = $collection->find();

        return $retrieved;
    }

    public function getUser($collection_name, $username) {
        $collection = $this->database->createCollection($collection_name);
        $retrieved = $collection->find(array("username" => $username));

        return $retrieved;
    }


}

?>
