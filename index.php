<?php

//use dao\ExamDao;
//use dao\GroupDao;
//use dao\ScheduleDao;
//use dao\SubjectDao;

define('CALLBACK_API_EVENT_CONFIRMATION', 'confirmation');
define('CALLBACK_API_EVENT_MESSAGE_NEW', 'message_new');

require_once 'config.php';
require_once 'global.php';
//require_once 'ExamDao.php';
require_once 'api/vk_api.php';
require_once 'api/yandex_api.php';

require_once 'dao/ExamDao.php';
require_once 'dao/GroupDao.php';
require_once 'dao/ScheduleDao.php';
require_once 'dao/SubjectDao.php';
require_once 'dao/AbstractDao.php';

require_once 'bot/bot.php';

if (!isset($_REQUEST)) {
    exit;
}

$examDao = new ExamDao();

callback_handleEvent($examDao);

function callback_handleEvent($examDao)
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
                _callback_handleMessageNew($event['object'], $examDao);
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

function _callback_handleMessageNew($data, $examDao)
{
    $user_id = $data['message']['from_id'];
    bot_sendMessage($user_id, "1");

    try {

        bot_sendMessage($user_id, "6");
        bot_sendMessage($user_id, $examDao->get_exams);
        bot_sendMessage($user_id, "7");
    } catch (Exception $e) {
        bot_sendMessage($user_id, "2");
        bot_sendMessage($user_id, $e->getMessage());
    }

    $scheduleDao = new ScheduleDao();
    $subjectDao = new SubjectDao();
    $groupDao = new GroupDao();

    bot_sendMessage($user_id, "3");

    $payload = null;

    if (isset($data['message']['payload'])) {
        $payload = json_decode($data['message']['payload']);
    }
    $group_id = $groupDao->get_group($user_id);

    if ($payload != null && strpos($payload->button, 'Group') === 0) {
        $args = explode(" ", $payload->button);
        $group_id = end($args);
        $groupDao->add_group($user_id, $group_id);
        bot_sendMessage($user_id, "Группа установлена!");
    }

    if ($group_id == null) {
        $key = json_decode(file_get_contents("bot/add_group.json"), true);
        vkApi_messagesSendWithKeyboard($user_id, "Выберите группу", $key);
        _callback_okResponse();
    }


    if ($payload != null && $payload->button == "session") {
        $exams = $examDao->get_exams($group_id);
        $ans = "";
        foreach ($exams as $exam) {
            $ans = $ans . $exam['subject_name'] . ' ' . $exam['ts'] . "\n";
        }
        vkApi_messagesSend($user_id, $ans);
    }

    if ($payload != null && $payload->button == "Main") {
        $key = json_decode(file_get_contents("bot/test.json"), true);
        vkApi_messagesSendWithKeyboard($user_id, "Выберите действие", $key);
        _callback_okResponse();
        exit();
    }

    if ($payload != null && $payload->button == "sch") {
        $key = json_decode(file_get_contents("bot/schedule_select.json"), true);
        vkApi_messagesSendWithKeyboard($user_id, "Выберите дату", $key);
        _callback_okResponse();
        exit();
    }

    if ($payload != null && $payload->button == "sch_today") {
        $date = new DateTime();
        $weekday = (int) $date->format('N');
        $res = help($user_id, $group_id, $weekday, $scheduleDao);
        vkApi_messagesSend($user_id, $res);
    }

    if ($payload != null && $payload->button == "sch_tomorrow") {
        $date = new DateTime();
        $date->modify('+1 day');
        $weekday = (int) $date->format('N');
        $res = help($user_id, $group_id, $weekday, $scheduleDao);
        vkApi_messagesSend($user_id, $res);
    }

    if ($payload != null && $payload->button == "sch_week") {
        $date = new DateTime();
        $ans="";
        for($i = 0; $i <= 6; $i++) {
            $date->modify("+1 day");
            $weekday = (int) $date->format('N');
            $ans = $ans . $date->format('Y-m-d') . "\n";
            $ans = $ans . help($user_id, $group_id, $weekday, $scheduleDao) . "\n\n";
        }

        vkApi_messagesSend($user_id, $ans);
    }

    if ($payload != null && $payload->button == "subjects") {
        $subjects = $subjectDao->get_subjects($user_id, $group_id);
        $array = array();
        foreach ($subjects as $subject) {
            $array[] = [["action" => [
                "type" => "text",
                "payload" => "{\"button\": \"Subject " . $subject['subject_id'] . "\"}",
                "label" => $subject['subject_name']],
                "color" => "default"]];
        }
        $array[] = [["action" => [
            "type" => "text",
            "payload" => "{\"button\": \"Main\"}",
            "label" => "На главную"],
            "color" => "default"]];

        $key = [
            "one_time" => false,
            "buttons" => $array
        ];

        vkApi_messagesSendWithKeyboard($user_id, "Выберите предмет", $key);
        _callback_okResponse();
        exit();
    }

    if ($payload != null && strpos($payload->button, "Subject") === 0) {
        $args = explode(" ", $payload->button);
        $subject_id = end($args);

        $subjects = $subjectDao->get_useful_links($subject_id);

        $array = array();
        foreach ($subjects as $subject) {
            $array[] = [["action" => [
                "type" => "open_link",
                "link" => $subject['link'],
                "payload" => "",
                "label" => $subject['link_name']]
            ]];
        }

        $array[] = [["action" => [
            "type" => "text",
            "payload" => "{\"button\": \"Main\"}",
            "label" => "На главную"],
            "color" => "default"]];

        $key = [
            "one_time" => false,
            "buttons" => $array
        ];


        vkApi_messagesSendWithKeyboard($user_id, "Выберите то что интересует", $key);
        _callback_okResponse();
        exit();
    }

    $key = json_decode(file_get_contents("bot/test.json"), true);
    vkApi_messagesSendWithKeyboard($user_id, "Выберите действие", $key);

    _callback_okResponse();
}

function help($user_id, $group_id, $weekday, $scheduleDao)
{
    $schedule = $scheduleDao->get_schedule($user_id, $group_id, $weekday);

    if(empty($schedule)) {
        return "В этот день нет пар";
    }
    $ans = "";
    foreach ($schedule as $class) {
        $ans = $ans . $class['start_class'] . '-' . $class['end_class'] . ' ' . $class['subject_name'] . "\n";
    }
    return $ans;
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


