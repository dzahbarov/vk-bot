<?php

function get_subjects($user_id, $group_id)
{

    $servername = "localhost";
    $username = "bot";
    $password = "@Aasdjkhkuhb43289b";
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=bot_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";

    } catch (PDOException $e) {
        bot_sendMessage($user_id, $e->getMessage());
        echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $conn->prepare("select * from Subjects where Subjects.group_id=:group_id");

    $stmt->execute([
        'group_id' => $group_id
    ]);

    $data = $stmt->fetchAll();
    return $data;
}

function get_useful_links($user_id, $subject_id)
{

    $servername = "localhost";
    $username = "bot";
    $password = "@Aasdjkhkuhb43289b";
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=bot_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";

    } catch (PDOException $e) {
        bot_sendMessage($user_id, $e->getMessage());
        echo "Connection failed: " . $e->getMessage();
    }

    $stmt = $conn->prepare("select * from Useful inner join Subjects on Useful.subject_id = Subjects.subject_id where Subjects.subject_id=:subject_id");

    $stmt->execute([
        'subject_id' => $subject_id
    ]);

    $data = $stmt->fetchAll();
    return $data;
}
