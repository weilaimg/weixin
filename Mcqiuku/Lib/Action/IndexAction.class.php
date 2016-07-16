<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    

    public function index(){
    	


    	//1.获得参数signature nonce token timestamp echostr
    	$signature		= $_GET['signature'];
    	$nonce 			= $_GET['nonce'];
    	$token 			= 'mcqiuku';
    	$echostr        = $_GET['echostr'];
    	$timestamp      = $_GET['timestamp'];

		//形成数组，按字典序排序

		$arr = array($nonce,$timestamp,$token);
		sort ($arr);
		//拼接成字符串，sha1加密，然后与signature进行校验
		$str = implode('', $arr);
		$str = sha1($str);
		
		if($str == $signature && $echostr)
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

				$Ttime = time ();
				$timeD = date('Y年m月d日',$Ttime);
				$timeH = date('H:m:s',$Ttime);
				$timeh = date ('H',$Ttime);
				if($timeh > 6 && $timeh < 8)
				{
					$Msg = '上午好';
				}
				else if ($timeh >=8 && $timeh <11)
				{
					$Msg = '早上好';
				}
				else if ($timeh >= 11 && $timeh <=13)
				{
					$Msg = '中午好';
				}
				else if($timeh >13 && $timeh < 18)
				{
					$Msg = '下午好';
				}
				else if ($timeh >=18 && $timeh <= 23 )
				{
					$Msg = '晚上好';
				}
				else
					$Msg = '大半夜不睡觉出来玩什么微信！';
				$content = "	欢迎关注
	[梅川湫褲·冷]
	官方微信平台
	===============	
			
	现在是:
	$timeD
	北京时间
	$timeH

	===============
	$Msg
	";




				$toUser = $postObj -> FromUserName;
				$fromUser = $postObj -> ToUserName;
				$time = time();
				$msgType = 'text';
			//	$content = 'Hello guys';

				/**
				 * 回复事件推送格式
			 	<xml>
				<ToUserName><![CDATA[toUser]]></ToUserName>
				<FromUserName><![CDATA[fromUser]]></FromUserName>
				<CreateTime>12345678</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[你好]]></Content>
				</xml>
				 */


				$template = '<xml>
				<ToUserName><![CDATA[%s]]></ToUserName>
				<FromUserName><![CDATA[%s]]></FromUserName>
				<CreateTime>%s</CreateTime>
				<MsgType><![CDATA[%s]]></MsgType>
				<Content><![CDATA[%s]]></Content>
				</xml>';


				$info = sprintf($template,$toUser,$fromUser,$time,$msgType,$content);
				echo $info; 	

			}


		}





    }

















}