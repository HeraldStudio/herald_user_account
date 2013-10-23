<?php
/**
 *
 *This is herald user account class
 *This class confirm user and create session for each user
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

	function __construct($username, $password){
		$this -> username = $username;
		$this -> password = $password;
		$this -> meminstance = new Memcache();
		$this -> meminstance -> pconnect('localhost', 11211);
		DbConnectModel::startConnect();
	}

	function __destruct(){
		DbConnectModel::closeConnect();
	}

	/*Entrance function of the class*/
	public function login(){
		//confirm user
		if($this -> confirmUserInfo() == "error"){
			echo "用户名密码或错误";
		}else{
			$this -> recordUserInfo();
			$this -> createSession();
			$this -> redirecturl = $_SERVER["HTTP_REFERER"];
			#Header("Location:".$this -> redirecturl);
			echo $this -> loginuserinfo;
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
		}
	} 

	//record user info
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