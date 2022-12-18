<?php

function get_exams($user_id, $group_id, $weekday)
{
    bot_sendMessage($user_id, "34");
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
    bot_sendMessage($user_id, "1oo");
    $stmt = $conn->prepare("select * from Schedule inner join Classes on Exams.subject_id = Subjects.subject_id where Schedule.weekday=:weekday");

    $stmt->execute([
        'group_id' => $group_id
    ]);

    $data = $stmt->fetchAll();
    return $data;
}

