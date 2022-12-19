<?php


abstract class AbstractDao
{
    public PDO $conn;

    final public function __construct()
    {
        $servername = BD_SERVERNAME;
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=" . BD_DATABASE, BD_USERNAME, BD_PASSWORD);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $this->conn = $conn;
    }
}