<?php

class Connection {

    public static function connect() {
        try {
            //$pdo = new PDO('mysql:host=172.18.1.35;dbname=siscali;charset=utf8', 'gustavo.morales', 'KliPET0234+', array(PDO::ATTR_PERSISTENT => true));
            //$pdo = new PDO('mysql:host=172.18.1.35;dbname=siscali;charset=utf8', 'siscali', '20*5i5C4l1&19', array(PDO::ATTR_PERSISTENT => true));
        //$pdo = new PDO('mysql:host=172.18.1.35;dbname=siscali;charset=utf8', 'siscali', '20*5i5C4l1&19', array(PDO::ATTR_PERSISTENT => true));
        //$pdo = new PDO('mysql:host=localhost;dbname=siscali;charset=utf8', 'siscali', '20*5i5C4l1&19', array(PDO::ATTR_PERSISTENT => true));
        $pdo = new PDO('mysql:host=localhost;dbname=siscali;charset=utf8', 'root', '', array(PDO::ATTR_PERSISTENT => true));
            return $pdo;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

}
