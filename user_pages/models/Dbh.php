<?php

class Dbh
{

    public function connect()
    {
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "tick&style";


        try {

            $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
            echo $conn;
        } catch (PDOException $e) {
            echo ("Connection failed: " . $e->getMessage());
        }
    }
}
