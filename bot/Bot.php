<?php

require_once 'dao/ExamDao.php';
require_once 'dao/GroupDao.php';
require_once 'dao/ScheduleDao.php';
require_once 'dao/SubjectDao.php';
require_once 'dao/AbstractDao.php';
require_once 'api/VkApi.php';

class Bot
{
    private VkApi $vk_api;
    private ExamDao $examDao;
    private GroupDao $groupDao;
    private ScheduleDao $scheduleDao;
    private SubjectDao $subjectDao;

    final public function __construct()
    {
        $this->vk_api = new VkApi();
        $this->examDao = new ExamDao();
        $this->scheduleDao = new ScheduleDao();
        $this->subjectDao = new SubjectDao();
        $this->groupDao = new GroupDao();
    }

    public function handleMessage($data): void
    {
        $user_id = $data['message']['from_id'];

        $payload = null;
        if (isset($data['message']['payload'])) {
            $payload = json_decode($data['message']['payload']);
        }

        if ($data['message']['text'] == 'Изменить группу') {
            $this->groupDao->rm_group($user_id);
        }

        $group_id = $this->groupDao->get_group($user_id);

        if ($payload != null && $payload->button == 'Group') {
            $this->groupDao->add_group($user_id, $payload->group_id);
            $this->vk_api->sendMessage($user_id, "Группа установлена! Чтобы ее изменить, напишите в чат \"Изменить группу\"");
            $this->showMainPage($user_id);
        }

        if ($group_id == null) {
            $this->showGroupChoosing($user_id);
        }

        if ($payload != null) {
            switch ($payload->button) {
                case "Main":
                    $this->showMainPage($user_id);
                    break;
                case "session":
                    $this->sendExams($user_id, $group_id);
                    $this->showMainPage($user_id);
                    break;
                case "sch":
                    $this->showSchedulePage($user_id);
                    break;
                case "sch_today":
                    $this->sendTodaySchedule($user_id, $group_id);
                    $this->showMainPage($user_id);
                    break;
                case "sch_tomorrow":
                    $this->sendTomorrowSchedule($user_id, $group_id);
                    $this->showMainPage($user_id);
                    break;
                case "sch_week":
                    $this->sendWeekSchedule($user_id, $group_id);
                    $this->showMainPage($user_id);
                    break;
                case "subjects":
                    $this->showSubjects($user_id, $group_id);
                    break;
                case "Subject":
                    $this->showSubject($payload->subject_id, $user_id);
                    break;
            }
        }
        $this->showMainPage($user_id);
    }

    private function getSchedule($group_id, $weekday): string
    {
        $schedule = $this->scheduleDao->get_schedule($group_id, $weekday);

        if (empty($schedule)) {
            return "В этот день нет пар";
        }
        $ans = "";
        foreach ($schedule as $class) {
            $ans = $ans . "{$class['start_class']} - {$class['end_class']}   {$class['subject_name']} \n";
        }
        return $ans;
    }

    private function showMainPage($user_id): void
    {
        $key = json_decode(file_get_contents("bot/keyboards/main.json"), true);
        $this->vk_api->sendMessageWithKeyboard($user_id, "Выберите действие", $key);
        _callback_okResponse();
        exit();
    }

    private function sendExams($user_id, $group_id)
    {
        $exams = $this->examDao->get_exams($group_id);
        $ans = "";
        foreach ($exams as $exam) {
            $ans = $ans . "{$exam['subject_name']} {$exam['ts']}\n";
        }
        $this->vk_api->sendMessage($user_id, $ans);
    }

    private function sendTodaySchedule($user_id, $group_id)
    {
        $date = new DateTime();
        $weekday = (int)$date->format('N');
        $res = $this->getSchedule($group_id, $weekday);
        $this->vk_api->sendMessage($user_id, $res);
    }

    private function sendTomorrowSchedule($user_id, $group_id)
    {
        $date = new DateTime();
        $date->modify('+1 day');
        $weekday = (int)$date->format('N');
        $res = $this->getSchedule($group_id, $weekday);
        $this->vk_api->sendMessage($user_id, $res);
    }

    private function sendWeekSchedule($user_id, $group_id)
    {
        $date = new DateTime();
        $ans = "";
        for ($i = 0; $i <= 6; $i++) {
            $date->modify("+1 day");
            $weekday = (int)$date->format('N');
            $ans = $ans . "{$date->format('Y-m-d')} \n";
            $ans = $ans . $this->getSchedule($group_id, $weekday) . "\n\n";
        }
        $this->vk_api->sendMessage($user_id, $ans);
    }

    private function showSchedulePage($user_id): void
    {
        $key = json_decode(file_get_contents("bot/keyboards/schedule_select.json"), true);
        $this->vk_api->sendMessageWithKeyboard($user_id, "Выберите дату", $key);
        _callback_okResponse();
        exit();
    }

    private function showGroupChoosing($user_id): void
    {
        $key = json_decode(file_get_contents("bot/keyboards/add_group.json"), true);
        $this->vk_api->sendMessageWithKeyboard($user_id, "Выберите группу", $key);
        _callback_okResponse();
        exit();
    }

    private function showSubjects($user_id, $group_id): void
    {
        $subjects = $this->subjectDao->get_subjects($group_id);
        $array = array();
        foreach ($subjects as $subject) {
            $array[] = [["action" => [
                "type" => "text",
                "payload" => "{\"button\": \"Subject\", \"subject_id\": \"{$subject['subject_id']}\"}",
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

        $this->vk_api->sendMessageWithKeyboard($user_id, "Выберите предмет", $key);
        _callback_okResponse();
        exit();
    }

    private function showSubject($subject_id, $user_id): void
    {
        $subjects = $this->subjectDao->get_useful_links($subject_id);

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

        $this->vk_api->sendMessageWithKeyboard($user_id, "Выберите то что интересует", $key);
        _callback_okResponse();
        exit();
    }
}


