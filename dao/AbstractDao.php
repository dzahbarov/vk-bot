<?php


abstract class AbstractDao
{
    public PDO $conn;

    final public function __construct()
    {
        $servername = BD_SERVERNAME;
        $database = BD_DATABASE;
        $username = BD_USERNAME;
        $password = BD_PASSWORD;
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=" . $database, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $this->conn = $conn;
    }
}