<?php

function bot_sendMessage($user_id, $text) {
  $users_get_response = vkApi_usersGet($user_id);
  $user = array_pop($users_get_response);
  $msg = "Привет, {$user['first_name']} - хуй! Ты сказал $text";



  //$photo = _bot_uploadPhoto($user_id, BOT_IMAGES_DIRECTORY.'/cat.jpeg');

  //$voice_message_file_name = yandexApi_getVoice($msg);
  //$doc = _bot_uploadVoiceMessage($user_id, $voice_message_file_name);

  //$attachments = array(
  //  'photo'.$photo['owner_id'].'_'.$photo['id'],
  //  'doc'.$doc['owner_id'].'_'.$doc['id'],
  //);

  vkApi_messagesSend($user_id, $msg);
}

