<?php

function get_schedule($user_id, $group_id, $weekday)
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
    $stmt = $conn->prepare("select Classes.subject_id, Subjects.subject_name,  start_class, end_class from Schedule left join Classes on class1_id=class_id or class2_id=class_id or class3_id=class_id or class4_id=class_id or class5_id=class_id or class6_id=class_id or class7_id=class_id inner join Subjects on Classes.subject_id=Subjects.subject_id where weekday=:weekday and Schedule.group_id=:group_id");

    $stmt->execute([
        'weekday' => $weekday,
        'group_id' => $group_id
    ]);

    $data = $stmt->fetchAll();
    return $data;
}

