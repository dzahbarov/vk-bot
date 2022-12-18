<?php

namespace dao;
class ScheduleDao extends AbstractDao
{
    public function get_schedule($user_id, $group_id, $weekday)
    {
        $stmt = $this->conn->prepare("select Classes.subject_id, Subjects.subject_name,  start_class, end_class from Schedule left join Classes on class1_id=class_id or class2_id=class_id or class3_id=class_id or class4_id=class_id or class5_id=class_id or class6_id=class_id or class7_id=class_id inner join Subjects on Classes.subject_id=Subjects.subject_id where weekday=:weekday and Schedule.group_id=:group_id");

        $stmt->execute([
            'weekday' => $weekday,
            'group_id' => $group_id
        ]);

        return $stmt->fetchAll();
    }
}



