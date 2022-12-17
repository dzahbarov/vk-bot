<?php

define('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation');
define('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new');

require_once 'config.php';
require_once 'global.php';

require_once 'api/vk_api.php';
require_once 'api/yandex_api.php';

require_once 'bot/bot.php';

if (!isset($_REQUEST)) {
    exit;
}

callback_handleEvent();

function callback_handleEvent()
{
    $event = _callback_getEvent();

    try {
        switch ($event['type']) {
            //Подтверждение сервера
            case CALLBACK_API_EVENT_CONFIRMATION:
                _callback_handleConfirmation();
                break;

            //Получение нового сообщения
            case CALLBACK_API_EVENT_MESSAGE_NEW:
                _callback_handleMessageNew($event['object']);
                break;

            default:
                _callback_response('Unsupported event');
                break;
        }
    } catch (Exception $e) {
        log_error($e);
    }

    _callback_okResponse();
}

function _callback_getEvent()
{
    return json_decode(file_get_contents('php://input'), true);
}

function _callback_handleConfirmation()
{
    _callback_response(CALLBACK_API_CONFIRMATION_TOKEN);
}

function _callback_handleMessageNew($data)
{
    $user_id = $data['message']['from_id'];
    $text = $data['message']['text'];

    add_group($user_id, $text);

//    $servername = "localhost";
//    $username = "bot";
//    $password = "@Aasdjkhkuhb43289b";
//    $dbname = "test_db";
//    $conn = null;
//    try {
//        $conn = new PDO("mysql:host=$servername;dbname=test_db", $username, $password);
//        // set the PDO error mode to exception
//        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//        echo "Connected successfully";
//    } catch(PDOException $e) {
//        log_error($e->getMessage());
//        bot_sendMessage($user_id, "Connection failed: " . $e->getMessage());
//        echo "Connection failed: " . $e->getMessage();
//    }
//    bot_sendMessage($user_id, "Connected successfully");
//
//    $res = $conn->query('SELECT * FROM test_table');
//
//    while ($row = $res->fetch())
//    {
//        bot_sendMessage($user_id, $row['test_col'] . "\n");
//    }

    bot_sendMessage($user_id, "successfully inserted!");
    _callback_okResponse();
}

function _callback_okResponse()
{
    _callback_response('ok');
}

function _callback_response($data)
{
    echo $data;
    exit();
}


