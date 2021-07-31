<?php

namespace fcm;

class Push2
{
    /**
     * FcmPush批量联网批量用户模式
     */
    public function index()
    {
        $index          = 0;
        $maxUserId      = db('user')->max('id');
        $fcmInfoResult  = array();

        $user_limit = config('fcm.user_limit');
        $title      = config('fcm.title');
        $content    = config('fcm.content');
        $curl_limit = config('fcm.curl_limit');
        do {
            $fcmInfo = array();
            $result = db('user')->where('id', '>', $index)->where('fcm_info', 'not null')->field('id,fcm_info')->limit($user_limit)->select();
            if (!$result) {
                break;
            }
            foreach ($result as $item) {
                if (!empty($item['fcm_info'])) {
                    array_push($fcmInfo, $item['fcm_info']);
                }
            }
            array_push($fcmInfoResult, $fcmInfo);
            unset($fcmInfo);
            $index = max($result)['id'];
            if ($index >= $maxUserId) {
                break;
            }
        } while (true);

        $rCount = count($fcmInfoResult);
        trace("maxUserId=$maxUserId", 'notice');
        trace("待执行PUSH任务组数量:$rCount", 'notice');

        $success    = 0;
        $failure    = 0;
        for ($i = 0; $i <= $rCount; $i += $curl_limit) {
            trace("for.i=$i", 'notice');
            $sendTokenData = array_slice($fcmInfoResult, $i, $curl_limit);
            $response = $this->doPostCurlMulti($title, $content, $sendTokenData);

            $success += $response['success'];
            $failure += $response['failure'];
        }
        $msg = "PUSH成功数:$success,失败数:$failure";
        return $msg;
    }

    private function doPostCurlMulti($title, $content, $tokens = array())
    {
        $headers = array(
            'Authorization: key=' . config('fcm.API_ACCESS_KEY'),
            'Content-Type: application/json'
        );
        $msg = array(
            'title' =>  $title,
            'body'  =>  $content,
        );

        $mh = curl_multi_init();
        $handle = array();
        $i = 0;
        foreach ($tokens as $item) {
            $fields = array(
                'registration_ids' => $item, //字符串数组
                'data'  => $msg
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            curl_multi_add_handle($mh, $ch);
            $handle[$i++] = $ch;
        }

        do {
            curl_multi_exec($mh, $running);
        } while ($running > 0);

        $success = 0;
        $failure = 0;
        foreach ($handle as $i => $ch) {
            $content = curl_multi_getcontent($ch);

            $jsonResult = json_decode($content, true);
            if (isset($jsonResult['failure'])) {
                $failure += $jsonResult['failure'];
                // if ($jsonResult['failure'] > 0) {
                //     trace("google_error_result=$content", 'error'); //有错误则记录日志
                // }
            }
            if (isset($jsonResult['success'])) {
                $success += $jsonResult['success'];
            }

            $data[$i] = (curl_errno($ch) == 0) ? $content : false;
        }
        trace("doPostCurlMulti:成功数$success,失败数:$failure", "notice");
        foreach ($handle as $ch) {
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
        }
        curl_multi_close($mh);
        $response = array('success' => $success, 'failure' => $failure);
        return $response;
    }
}
