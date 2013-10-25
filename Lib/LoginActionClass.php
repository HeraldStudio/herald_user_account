<?php
/**
 *
 *This class achieve login action for herald user account
 *Client app can post the username and password to this 
 *class.
 *If the right username and password combination has given.
 *It will return a json format data with user information and 
 *some success message. Otherwise, It will return a json format
 *error information with error type and error message. The detaile
 *message please read the documentation on github of Heraldstudio
 *
 * 
 *@author Tairy <tairyguo@gmail.com>
*@version 2.0
 *@copyright HeraldStudio SEU
 *
 **/

require 'DbConnectModel.class.php';
define("EXPAIRED_TIME", 3600);

class LoginAction{
	private $username;
	private $password;
	private $cardnum;
	private $truename;
	private $sessionid;
	private $meminstance;
	private $cookie;
	private $loginuserinfo;
	private $redirecturl;
	private $errorinfo;
	private $successinfo;
	private $isgetinfo;

	function __construct(){
		$this -> username = $_POST['username'];
		$this -> password =  $_POST['password'];
		$requesturl = parse_url($_SERVER["HTTP_REFERER"]);
		$requesturl = explode('=', $requesturl['query']);

		if($requesturl[0] == "redirecturl"){

			if(!empty($requesturl[1])){
				$this -> redirecturl = $requesturl[1];
			}else{
				$this -> redirecturl = $_SERVER["HTTP_REFERER"];
			}
		}else{
			$this -> redirecturl = $_SERVER["HTTP_REFERER"];
		}
		$this -> isgetinfo = true;
		$this -> meminstance = new Memcache();
		$this -> meminstance -> pconnect('localhost', 11211);
		DbConnectModel::startConnect();
	}

	function __destruct(){
		DbConnectModel::closeConnect();
	}

	public function login(){
		if($this -> confirmUserInfo() == "error"){
			$this -> errorinfo['code'] = 1;
			$this -> errorinfo['type'] = "AccountError";
			$this -> errorinfo['message'] = "用户名或密码错误!";
			echo json_encode($this -> errorinfo);
		}else{
			$this -> recordUserInfo();
			$this -> createSession();
			if($this -> isgetinfo){
				$this -> successinfo['code'] = 200;
				$this -> successinfo['message'] = "登录成功!";
				$this -> successinfo['data'] = $this -> loginuserinfo;
				$this -> successinfo['redirecturl'] = $this -> redirecturl;
				//echo $this -> redirecturl;
				echo json_encode($this -> successinfo);
			}
		}
	}

	private function confirmUserInfo(){
		$ch = curl_init();
		$postdata ="username=".$this -> username."&password=".$this -> password;
		curl_setopt($ch, CURLOPT_URL, 'http://121.248.63.105:8080/authentication/');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		$responseword = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);
		if($info['http_code'] == 401){
			return "error";
		}elseif($info['http_code'] == 200){
			$responseword = explode(',', $responseword);
			$this -> truename = $responseword[0];
			$this -> cardnum = $responseword[1];
		}elseif($info['http_code'] == 0){
			$this -> errorinfo['code'] = 1;
			$this -> errorinfo['type'] = "ServerError";
			$this -> errorinfo['message'] = "服务器故障!";
			echo json_encode($this -> errorinfo);
			$this -> isgetinfo = false;
		}
	} 

	private function recordUserInfo(){
		$sql = "INSERT INTO `herald_user` (`card_num`, `true_name`) VALUES ('".$this -> cardnum."', '".$this -> truename."')";
		mysql_query($sql);
	}

	private function createSession(){
		$userinfo['truename'] = $this -> truename;
		$userinfo['cardnum'] = $this -> cardnum;
		$this -> loginuserinfo = json_encode($userinfo);
		$this -> createSessionId();
		setcookie('HERALD_USER_SESSION_ID', $this -> sessionid, time()+3600000, '/');
		$this -> meminstance -> set($this -> sessionid, $this -> loginuserinfo, 0, EXPAIRED_TIME);#half an hour
	}

	private function createSessionId(){
		$this -> sessionid =  md5($this -> cardnum + rand() + time());
	}
}