<?php

define('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation');
define('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new');

require_once 'config.php';
require_once 'global.php';

require_once 'dao/groupDao.php';
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

    $payload = null;

//    bot_sendMessage($user_id, $data['message']['payload']);

    if (isset($data['message']['payload'])) {
        bot_sendMessage($user_id, "-2");
        $payload = json_decode($data['message']['payload']);
    }
    $group_id = get_group($user_id);

    if ($group_id == null) {
        $key = json_decode(file_get_contents("bot/add_group.json"), true);
        vkApi_messagesSendWithKeyboard($user_id, "Hi", $key);
        _callback_okResponse();
    }

    bot_sendMessage($user_id, "-1");
    if ($payload != null && $payload->button == "2") {
        bot_sendMessage($user_id, "0");
        $exams = get_exams($user_id, $group_id);
        bot_sendMessage($user_id, "1");
        $ans = "";
        foreach ($exams as $exam) {
            bot_sendMessage($user_id, "2");
            bot_sendMessage($user_id, $exam['subject_name']);
            bot_sendMessage($user_id, $ans);
            $ans = $ans . $exam['subject_name'] . $exam['ts'] . '\n';
        }
        bot_sendMessage($user_id, "3");
        vkApi_messagesSend($user_id, $ans);
    }


    $key = json_decode(file_get_contents("bot/test.json"), true);
    vkApi_messagesSendWithKeyboard($user_id, "Hi. your group " . $group_id, $key);


//    $key = "{  \n   \"one_time\":false,\n   \"buttons\":[  \n      [  \n         {  \n            \"action\":{  \n               \"type\":\"location\",\n               \"payload\":\"{\\\"button\\\": \\\"1\\\"}\"\n            }\n         }\n      ],\n      [  \n         {  \n            \"action\":{  \n               \"type\":\"open_app\",\n               \"app_id\":6232540,\n               \"owner_id\":-157525928,\n               \"hash\":\"123\",\n               \"label\":\"LiveWidget\"\n            }\n         }\n      ],\n      [  \n         {  \n            \"action\":{  \n               \"type\":\"vkpay\",\n               \"hash\":\"action=transfer-to-group&group_id=181108510&aid=10\"\n            }\n         }\n      ],\n      [  \n         {  \n            \"action\":{  \n               \"type\":\"text\",\n               \"payload\":\"{\\\"button\\\": \\\"1\\\"}\",\n               \"label\":\"Red\"\n            },\n            \"color\":\"negative\"\n         },\n         {  \n            \"action\":{  \n               \"type\":\"text\",\n               \"payload\":\"{\\\"button\\\": \\\"2\\\"}\",\n               \"label\":\"Green\"\n            },\n            \"color\":\"positive\"\n         },\n         {  \n            \"action\":{  \n               \"type\":\"text\",\n               \"payload\":\"{\\\"button\\\": \\\"2\\\"}\",\n               \"label\":\"Blue\"\n            },\n            \"color\":\"primary\"\n         },\n         {  \n            \"action\":{  \n               \"type\":\"text\",\n               \"payload\":\"{\\\"button\\\": \\\"2\\\"}\",\n               \"label\":\"White\"\n            },\n            \"color\":\"secondary\"\n         }\n      ]\n   ]\n}";
//    $key = json_decode(file_get_contents("bot/test.json"), true);
//    vkApi_messagesSendWithKeyboard($user_id, "Hi", $key);

//    add_group($user_id, $text);

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


