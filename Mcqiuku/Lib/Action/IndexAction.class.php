<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    

    public function index(){
    	


    	//1.获得参数singature nonce token timestamp echostr
    	$singature		= $_GET['singature'];
    	$nonce 			= $_GET['nonce'];
    	$token 			= 'mcqiuku';
    	$echostr        = $_GET['echostr'];
    	$timestamp      = $_GET['timestamp'];

		//形成数组，按字典序排序

		$arr = array($nonce,$timestamp,$token);
		sort ($arr);
		//拼接成字符串，sha1加密，然后与singature进行校验
		$str = implode('', $arr);
		$str = sha1($str);
		
		if($str == $singature && $echostr)
		{
			//首次微信接入验证
			echo $echostr;
			die;
		}
		else 
		{
			//消息回复
			$this -> reponseMsg();
		}

    }

    /**
     * 接收事件推送并进行回复
        推送事件的xml格式：
        <xml>
		<ToUserName><![CDATA[toUser]]></ToUserName>
		<FromUserName><![CDATA[FromUser]]></FromUserName>
		<CreateTime>123456789</CreateTime>
		<MsgType><![CDATA[event]]></MsgType>
		<Event><![CDATA[subscribe]]></Event>
		</xml>
     */

    public function reponseMsg(){

    	//1.获取到微信post过来的（xml格式）数据
    	$postArr = $GLOBALS[HTTP_RAW_POST_DATA];

		//2.将xml格式的文本转化为对象
		$postObj = simplexml_load_string($postArr);

		//3.判断该数据是否是订阅的事件推送
		if(strtolower($postObj -> MsgType) == 'event'){
			
			//4.判断推送的事件是否是被添加的事件
			if(strtolower($postObj -> Event) == 'subscribe' ){
				//5.设置回复内容
				$toUser = $postObj -> FromUserName;
				$fromUser = $postObj -> ToUserName;
				$time = time();
				$msgType = 'text';
				$content = 'Hello guys';

				/**
				 * 回复事件推送格式
				 	<xml>
					<ToUserName><![CDATA[toUser]]></ToUserName>
					<FromUserName><![CDATA[FromUser]]></FromUserName>
					<CreateTime>123456789</CreateTime>
					<MsgType><![CDATA[event]]></MsgType>
					<Event><![CDATA[subscribe]]></Event>
					</xml>
				 */


				$template = '<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Event><![CDATA[%s]]></Event>
				</xml>';


				$info = sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
				echo $info; 	

			}


		}





    }

















}