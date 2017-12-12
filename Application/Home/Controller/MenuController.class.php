<?php
namespace Home\Controller;
use Think\Controller;

class MenuController extends BaseController {
    public function createMenu()
    {
        $menu = array(
            'button' => array(
                array(
                    'type' => 'click',
                    'name' => '中文标题',
                    'key' => 'is_key'
                )
            ));
        $menu = json_encode($menu, JSON_UNESCAPED_UNICODE);

        $response = $this->curlPost("https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$this->accessToken", $menu);
        $this->echoPre($response);
    }

    public function getMenu()
    {
        $response = $this->curlGet("https://api.weixin.qq.com/cgi-bin/menu/get?access_token=$this->accessToken");
        $this->echoPre($response);
    }
}