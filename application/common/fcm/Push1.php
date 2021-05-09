<?php

namespace app\jobs\controller;

class Push1
{
    /**
     * FcmPush单次联网批量用户模式
     */
    public function index()
    {
        $index      = 0;
        $success    = 0;
        $failure    = 0;
        $maxUserId  = db('user')->max('id');

        $user_limit = config('fcm.user_limit');
        $title      = config('fcm.title');
        $content    = config('fcm.content');
        $seconds    = config('fcm.sleep_seconds');
        do {
            $fcmModel = array();
            $result = db('user')->where('id', '>', $index)->where('fcm_info', 'not null')->field('id,fcm_info')->limit($user_limit)->select();
            if (!$result) {
                break;
            }
            foreach ($result as $item) {
                if (!empty($item['fcm_info'])) {
                    array_push($fcmModel, $item['fcm_info']);
                }
            }

            $fcmCount = count($fcmModel);
            if ($fcmCount > 0 && $fcmCount <= 1000) {
                $response = $this->doPostCurl($title, $content, $fcmModel);

                $success += $response['success'];
                $failure += $response['failure'];
                unset($fcmModel);
            }

            $index = max($result)['id'];
            if ($index >= $maxUserId) {
                break;
            }
            sleep($seconds);
        } while (true);
        $msg = "PUSH成功数:$success,失败数:$failure";
        return $msg;
    }

    private function doPostCurl($title, $content, $tokens = array())
    {
        $msg = array(
            'title' =>  $title,
            'body'  =>  $content,
        );
        $fields = array(
            'registration_ids' => $tokens, //字符串数组
            'data'  => $msg
        );
        $postData = json_encode($fields);

        $headers = array(
            'Authorization: key=' . config('fcm.API_ACCESS_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $result = curl_exec($ch);
        // trace($result);
        $error = curl_error($ch);
        if (!empty($err)) {
            $errno = curl_errno($ch);
            trace("CURL:errno=$errno,error=$error", 'error');
        }
        curl_close($ch);

        $response = array('failure' => 0, 'success' => 0);
        $jsonResult = json_decode($result, true);
        if (isset($jsonResult['failure'])) {
            $response['failure'] = $jsonResult['failure'];
        }
        if (isset($jsonResult['success'])) {
            $response['success'] = $jsonResult['success'];
        }
        return $response;
    }
}
