<?php

require_once 'dao/AbstractDao.php';

class GroupDao extends AbstractDao
{

    public function add_group($user_id, $group_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO Students (user_vk_id, group_id) VALUES (:user_vk_id,:group_id)");
        $stmt->execute([
            'user_vk_id' => $user_id,
            'group_id' => $group_id
        ]);
    }

    public function get_group($user_id)
    {
        $stmt = $this->conn->prepare("SELECT group_id from Students where user_vk_id=:user_vk_id");
        $stmt->execute(['user_vk_id' => $user_id]);

        $res = $stmt->fetch();

        if (!empty($res)) {
            return $res[0]['group_id'];
        }
        return null;
    }

    public function rm_group($user_id)
    {
        $stmt = $this->conn->prepare("DELETE from Students where user_vk_id=:user_vk_id");
        $stmt->execute(['user_vk_id' => $user_id]);
    }
}



