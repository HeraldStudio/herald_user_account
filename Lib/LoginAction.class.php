<?php
/**
 *
 *@filename LoginAction.class.php
 *@author GuoGengrui <tairyguo@gmail.com>
 *@version 1.0.0
 * 
 *
 * */
require_once 'DbConnectModel.class.php';

class LoginAction{
	private $username;
	private $password;
	private $remenberme;
	private $truename;
	private $userip;
	private $expiredtime;
	private $sessionid;

	function __construct(){
		$this -> username = "213111517";//$_POST['username'];
		$this -> password = "ggr123,.";//$_POST['password'];
//		$this -> rememberme = $_POST['remenberme'];
		DbConnectModel::startConnect();
	}
	function __destruct(){
		DbConnectModel::closeConnect();
	}
	public function main(){
		$result = $this -> confirmUserinfo();
		if($result == "error"){
			echo "用户名或密码错误";
			return;
		}else{
			$this -> resolveData($result);
		}
	}
	public function confirmUserinfo(){
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
		 	return $responseword;
		 }
	}
	public function resolveData($result){
		$result = explode(',',$result);
		$this -> truename = $result[0];
		$this -> sessionid = $this -> createSessionId($this -> username, $this -> password);
		if($this -> remenberme == 0){
			$this -> expiredtime = time()+3600000;
			setcookie('HERALD_USER_SESSION_ID', $this -> sessionid, $this -> expiredtime);
		}elseif($this -> rememberme == 1){
			$this -> expiredtime = time()+1000000000;
			setcookie('HERALD_USER_SESSION_ID', $this -> sessionid, $this -> expiredtime);
		}	
		$this -> addData();
	}
	private function createSessionId( $username, $password ){
		$session_id = $this -> phphash($username) + $this -> phphash($password) + rand() + time();
		return md5($session_id);
	}
	public function phphash($str){		
		$seed=31;
		$hash=0;
		for ($i = 0; $i < strlen($str); $i++){
			$hash = $hash * $seed + ord($str[$i]);
		}
		return $hash & 0x7fffffff;

	}
	private function addData(){
		$sql_a = "INSERT INTO `herald_user` (card_num, true_name, last_login_time, login_times) VALUES ('".$this -> username."', '".$this -> truename."', '".date('Y-m-d G:i:s')."', `login_times`+1)";
		$sql_b = "INSERT INTO `herald_session` (session_id, ip, login_time, expired_time) VALUES ('".$this -> sessionid."', '127.0.0.1', '".time()."', '".$this -> expiredtime."')";
		mysql_query($sql_a);
		mysql_query($sql_b);
		if(mysql_errno()){
			mysql_query('rollback');
			echo 'err';
		}else{
			mysql_query('commit');
			echo "ok";
		}
	}
}
