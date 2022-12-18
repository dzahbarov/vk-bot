<?php

class SubjectDao extends AbstractDao {
    function get_subjects($user_id, $group_id) {
        $stmt = $this->conn->prepare("select * from Subjects where Subjects.group_id=:group_id");
        $stmt->execute(['group_id' => $group_id]);
        return $stmt->fetchAll();
    }

    function get_useful_links($subject_id) {
        $stmt = $this->conn->prepare("select * from Useful inner join Subjects on Useful.subject_id = Subjects.subject_id where Subjects.subject_id=:subject_id");
        $stmt->execute(['subject_id' => $subject_id]);
        return $stmt->fetchAll();
    }
}


