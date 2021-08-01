<?php

namespace notify;

class Telegram
{
    private static $host     = "https://api.telegram.org/";
    private static $botToken = "1913301xxx:AAFUIyYRDYgLEOvjHtn_H3nxjQGMB-idtu8"; // 机器人ApiToken
    private static $chatId   = -582110666; // 私聊/群聊 ID

    /**
     * 发送TG消息
     * Telegram::sendMessage("testMessage");
     *
     * @param string $message
     * @return void
     */
    public static function sendMessage($message)
    {
        $url = self::$host . 'bot' . self::$botToken . '/sendMessage';

        $params['chat_id'] = self::$chatId;
        $params['text']    = $message;

        $result = do_curl($url, $params, 'GET');
        if ($result["ret"] != true) {
            trace($result['msg'], 'error');
        }
        $data = json_decode($result['data'], true);
        if ($data['ok'] != true) {
            trace($result['data'], 'error');
        }
    }
}

// 1.创建机器人
// https://telegram.me/botfather 手机端搜索 BotFather
// 创建成功得到机器人ApiToken

// 2.获取chat_id
// 将电报BOT添加到组中,发送消息
// 获取您的BOT的更新列表：
// https://api.telegram.org/bot<YourBOTToken>/getUpdates
// 例如：
// https://api.telegram.org/bot123456789:jbd78sadvbdy63d37gda37bd8/getUpdates
// 个人: result.message.chat.id
// 群聊: result.my_chat_member.chat.id

// 3.发送消息
// https://api.telegram.org/bot1913301xxx:AAFUIyYRDYgLEOvjHtn_H3nxjQGMB-idtu8/sendMessage?chat_id=-582110666&text=helloworld
