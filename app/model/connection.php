<?php

class Connection {

    public function connect() {
        try {
            $pdo = new PDO('mysql:host=localhost;dbname=siscali;charset=utf8', 'root', '', array(PDO::ATTR_PERSISTENT => true));
            return $pdo;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
