<?php
require_once 'dao/AbstractDao.php';

class ScheduleDao extends AbstractDao
{
    public function get_schedule($group_id, $weekday)
    {
        $stmt = $this->conn->prepare("select Classes.subject_id, Subjects.subject_name,  start_class, end_class from Classes inner join Subjects on Classes.subject_id=Subjects.subject_id where group_id=:group_id and weekday=:weekday");

        $stmt->execute([
            'weekday' => $weekday,
            'group_id' => $group_id
        ]);

        return $stmt->fetchAll();
    }
}



