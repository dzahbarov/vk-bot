<?php

function bot_sendMessage($user_id, $text) {
  $users_get_response = vkApi_usersGet($user_id);
  $user = array_pop($users_get_response);

  vkApi_messagesSend($user_id, $text);
}

