<?php
/**
 * To use this trait, the PHP Object's constructor should have
 * $id, $conn, $tabel variables set.
 * 
 * $id - The ID of the MySQL Table Row.
 * $conn - The MySQL Connection.
 * $table - The MySQL Table Name.
 */
trait SQLGetterSetter{

    private function _get_data($var)
    {
        // print($var);
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "SELECT `$var` FROM `$this->table` WHERE `id` = $this->id";
        // echo $sql ."--". __CLASS__;
        //print($sql);
        $result = $this->conn->query($sql);
        if ($result and $result->num_rows == 1) {
            //print("Res: ".$result->fetch_assoc()["$var"]);
            return $result->fetch_assoc()["$var"];
        } else {
            return null;
        }
    }

    //This function helps to  set the data in the database
    private function _set_data($var, $data)
    {
        if (!$this->conn) {
            $this->conn = Database::getConnection();
        }
        $sql = "UPDATE `$this->table` SET `$var`='$data' WHERE `id`=$this->id;";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
    public function __call($name, $arguments)
    {
        $property = preg_replace("/[^0-9a-zA-Z]/", "", substr($name, 3));
        $property = strtolower(preg_replace('/\B([A-Z])/', '_$1', $property));
        if (substr($name, 0, 3) == "get") {
            return $this->_get_data($property);
        } elseif (substr($name, 0, 3) == "set") {
            return $this->_set_data($property, $arguments[0]);
        } else {
            throw new Exception("Post::__call() -> $name, function unavailable.");
        }
    }
}