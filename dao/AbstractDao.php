<?php

namespace dao;

use PDO;
use PDOException;

abstract class AbstractDao
{
    public PDO $conn;

    final public function __construct()
    {
        $servername = "localhost";
        $username = "bot";
        $password = "@Aasdjkhkuhb43289b";
        $conn = null;
        try {
            $conn = new PDO("mysql:host=$servername;dbname=bot_db", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
        $this->conn = $conn;
    }
}