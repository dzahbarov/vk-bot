<?php

function add_group($user_id, $group_name)
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
    $stmt = $conn->prepare("INSERT INTO group_table (user_vk_id, group_name) VALUES (:user_vk_id,:group_name)");
    $stmt->execute([
        'user_vk_id' => $user_id,
        'group_name' => $group_name
    ]);
}

function get_group($user_id)
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
        bot_sendMessage($user_id, "3");
    } catch (PDOException $e) {
        bot_sendMessage($user_id, $e->getMessage());
        echo "Connection failed: " . $e->getMessage();
    }
    bot_sendMessage($user_id, "4");
    $stmt = $conn->prepare("SELECT group_name from group_table where user_vk_id=:user_vk_id");
    $stmt->execute([
        'user_vk_id' => $user_id
    ]);

    try {
        return $stmt->fetch()[0]['group_name'];
    } catch (Exception $e) {
        return null;
    }


}

