<?php
namespace Home\Controller;

class OptController extends BaseController {
    public function getAccessToken()
    {
        $response = $this->curlGet("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret");
        $access_token = $response['access_token'];

        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $redis->set('access_token', $access_token);

        echo $access_token;
    }

}