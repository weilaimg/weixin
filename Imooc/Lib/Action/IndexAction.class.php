<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
   	
	


	 public function index(){
	//$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
   
	//1.获得参数singature nonce token timestamp echostr
	$singature = $_GET['singature'];
	$nonce     = $_GET['nonce'];
	$timestamp = $_GET['timestamp'];
	$token     = 'weixin';
	$echostr   = $_GET['echostr'];
	//形成数组，按字典序排序
	$array = array('$nonce','timestamp','token');
	sort($array);
	//拼接成字符串，sha1加密，然后与singature进行校验
	$str = sha1( impolde($array)   );
	if ($str  == $singature && $echostr )
	{//第一次接入微信API时进行的验证
		echo $echostr;
		exit;
	}
	else
	{
		$this -> responseMsg();
	}

}
	



	//接收事件推送并回复
	/*接收消息的xml格式
	<xml>
	<ToUserName><![CDATA[toUser]]></ToUserName>
	<FromUserName><![CDATA[FromUser]]></FromUserName>
	<CreateTime>123456789</CreateTime>
	<MsgType><![CDATA[event]]></MsgType>
	<Event><![CDATA[subscribe]]></Event>
	</xml>
	*/

	public function responseMsg(){

		1.获取到微信post过来的（xml格式）数据
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];

		2.处理消息类型，并设置自动回复内容
		$postObj = simplexml_load_string($postArr);

		//判断该数据是否是订阅的事件推送
		if(strtolower ($postObj->MsgType) == 'event')
		{	//如果是关注subscribe事件
			if (strtolower($postObj -> Event)=='subscribe')
			{
				//回复用户消息
				$toUser = $postObj -> FromUserName;
				$fromUser = $opstObj -> ToUserName;
				$time = time();
				$msgType = 'text';
				$content = 'Hello guys!' ;
				$template = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					</xml>";

				/*回复消息的xml格式
				<xml>
				<ToUserName><![CDATA[toUser]]></ToUserName>
				<FromUserName><![CDATA[fromUser]]></FromUserName>
				<CreateTime>12345678</CreateTime>
				<MsgType><![CDATA[text]]></MsgType>
				<Content><![CDATA[你好]]></Content>
				</xml>
				*/

				$info = sprintf($template,$toUser,$$fromUser,$time,$mspType,$content);
				echo $info;
		
		} 		
	}























}
