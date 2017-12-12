<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/8
 * Time: 14:38
 */

namespace Home\Controller;
use Think\Cache\Driver\Redis;
use Think\Controller;

class BaseController extends Controller
{
    public $appId;
    public $appSecret;
    public $accessToken;

    public function __construct()
    {
        $this->appId = C('AppID');
        $this->appSecret = C('appsecret');
        $this->accessToken = $this->getAccessToken();
    }

    public function getAccessToken()
    {
        $redis = new \Redis();
        $redis->connect('127.0.0.1',6379);
        $accessToken = $redis->get('access_token');
        return $accessToken;
    }

    public function curlGet($url)
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        return json_decode($output, true);
    }

    public function curlPost($url, $post_data)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);

        $output = curl_exec($ch);
        curl_close($ch);

        //打印获得的数据
        return json_decode($output, true);
    }

    public function getCallBackIp()
    {
        $accessToken = $this->getAccessToken();
        $response = $this->curlGet("https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=$accessToken");

        return $response['ip_list'];
    }

    public function echoPre($arr)
    {
        echo "<pre>";
        print_r($arr);
    }

    public function arrayToXml($arr){
        $xml = "<xml>";
        foreach ($arr as $key=>$val){
            if(is_array($val)){
                $xml.="<".$key.">".arrayToXml($val)."</".$key.">";
            }else{
                $xml.="<".$key.">".$val."</".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
}
