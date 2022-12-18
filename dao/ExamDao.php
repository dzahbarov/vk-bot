<?php

class ExamDao extends AbstractDao {
    function get_exams($group_id) {
        $stmt = $this->conn->prepare("select * from Exams inner join Subjects on Exams.subject_id = Subjects.subject_id where Subjects.group_id=:group_id");
        $stmt->execute(['group_id' => $group_id]);
        return $stmt->fetchAll();
    }
}



