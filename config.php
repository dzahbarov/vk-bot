<?php

const BOT_BASE_DIRECTORY = '/var/vk-bot';
const BOT_LOGS_DIRECTORY = BOT_BASE_DIRECTORY . '/logs';
define('CALLBACK_API_CONFIRMATION_TOKEN', getenv('CALLBACK_API_CONFIRMATION_TOKEN'));
define('VK_API_ACCESS_TOKEN', getenv('VK_API_ACCESS_TOKEN'));
define('BD_SERVERNAME', getenv('BD_SERVERNAME'));
define('BD_DATABASE', getenv('BD_DATABASE'));
define('BD_USERNAME', getenv('BD_USERNAME'));
define('BD_PASSWORD', getenv('BD_PASSWORD'));