<?php

function add_group($user_id, $group_id)
{
    $servername = "localhost";
    $username = "bot";
    $password = "@Aasdjkhkuhb43289b";
    $conn = null;
    try {
        $conn = new PDO("mysql:host=$servername;dbname=bot_db", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        bot_sendMessage($user_id, $e->getMessage());
        echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->prepare("INSERT INTO Students (user_vk_id, group_id) VALUES (:user_vk_id,:group_id)");
    $stmt->execute([
        'user_vk_id' => $user_id,
        'group_id' => $group_id
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

    } catch (PDOException $e) {
        bot_sendMessage($user_id, $e->getMessage());
        echo "Connection failed: " . $e->getMessage();
    }
    $stmt = $conn->prepare("SELECT group_id from Students where user_vk_id=:user_vk_id");
    $stmt->execute([
        'user_vk_id' => $user_id
    ]);

    try {
        return $stmt->fetch()[0]['group_id'];
    } catch (Exception $e) {
        bot_sendMessage($user_id, "catch");
        return null;
    }


}

