<?php

function add_group($user_id, $group_name) {
    bot_sendMessage($user_id, "2");
    $servername = "localhost";
    $username = "bot";
    $password = "@Aasdjkhkuhb43289b";
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=test_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
        bot_sendMessage($user_id, "3");
    } catch(PDOException $e) {
        bot_sendMessage($user_id, $e->getMessage());

        echo "Connection failed: " . $e->getMessage();
    }
    bot_sendMessage($user_id, "4");
    $stmt= $conn->prepare("INSERT INTO group_table (user_vk_id, group_name) VALUES (:user_vk_id,:group_name)");
//    $stmt->bindParam(1, $user_id);
//    $stmt->bindParam(2, $group_name);
    $stmt->execute([
        'user_vk_id' => $user_id,
        'group_name' => $group_name
    ]);
    bot_sendMessage($user_id, "6");
}

