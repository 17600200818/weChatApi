<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {
    public function index(){
        //修改url接入代码
//        echo I('echostr');
//        exit();

        //接收微信消息
        $xmldata=file_get_contents("php://input");
        $data=simplexml_load_string($xmldata, 'SimpleXMLElement', LIBXML_NOCDATA);

        //返回xml参数
        $xml =  "<xml> <ToUserName><![CDATA[$data->FromUserName]]></ToUserName> <FromUserName><![CDATA[$data->ToUserName]]></FromUserName> <CreateTime>".time()."</CreateTime> <MsgType><![CDATA[text]]></MsgType> <Content><![CDATA[你好]]></Content> </xml>";
        echo $xml;

        //记录日志
        $data = json_encode($data);
        error_log(date("Y-m-d H:i:s")." ".$data."\n",3,APP_PATH."./Runtime/Logs/Home/".date("Ymd").".log");
    }
}