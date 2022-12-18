<?php


class VkApi
{
    const VK_API_VERSION = "5.131";
    const VK_API_ENDPOINT = "https://api.vk.com/method/";

    public function sendMessage($peer_id, $message)
    {
        return $this->call('messages.send', array(
                'peer_id' => $peer_id,
                'message' => $message,
                'random_id' => rand())
        );
    }

    public function sendMessageWithKeyboard($peer_id, $message, $keyboard)
    {
        return $this->call('messages.send', array(
                'peer_id' => $peer_id,
                'message' => $message,
                'random_id' => rand(),
                'keyboard' => json_encode($keyboard)
            )
        );
    }

    private function call($method, $params = array())
    {
        $params['access_token'] = VK_API_ACCESS_TOKEN;
        $params['v'] = VkApi::VK_API_VERSION;

        $query = http_build_query($params);
        $url = self::VK_API_ENDPOINT . $method . '?' . $query;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $json = curl_exec($curl);
        $error = curl_error($curl);
        if ($error) {
            log_error($error);
            throw new Exception("Failed {$method} request");
        }

        curl_close($curl);

        $response = json_decode($json, true);
        if (!$response || !isset($response['response'])) {
            log_error($json);
            throw new Exception("Invalid response for {$method} request");
        }

        return $response['response'];
    }
}

