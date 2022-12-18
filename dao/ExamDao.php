<?php

namespace dao;

use PDO;
use PDOException;

class ExamDao  {
    public function get_exams($group_id) {
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
        $stmt = $this->conn->prepare("select * from Exams inner join Subjects on Exams.subject_id = Subjects.subject_id where Subjects.group_id=:group_id");
        $stmt->execute(['group_id' => $group_id]);
        return $stmt->fetchAll();
    }
}



