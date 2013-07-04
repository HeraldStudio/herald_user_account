<?php
/**
 *
 *@filename LoginAction.class.php
 *@author GuoGengrui <tairyguo@gmail.com>
 *@version 1.0.0
 *@copyright HeraldStudio SEU
 *
 * */
require_once 'DbConnectModel.class.php';

class LoginAction{
	private $username;
	private $password;
	private $truename;
	private $userip;
	private $expiredtime;
	private $sessionid;

	function __construct(){
		$this -> username = $this -> htmlencode($_POST['username']);
		$this -> password = $this -> htmlencode($_POST['password']);
		DbConnectModel::startConnect();
	}
	function __destruct(){
		DbConnectModel::closeConnect();
	}
	public function main(){
		if(!empty($_COOKIE['HERALD_USER_SESSION_ID']) && $this -> isUserLogin()){
			echo "已登录";
			return;
		}else{
			$result = $this -> confirmUserinfo();
			if($result == "error"){
				echo "用户名或密码错误";
				return;
			}else{
				$rs = $this -> resolveData($result);
				if($rs == "success"){
					echo "登录成功";
				}else{
					echo "登录失败";
				}
			}
		}
	}
	private function confirmUserinfo(){
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
	private function resolveData($result){
		$result = explode(',',$result);
		$this -> truename = $result[0];
		$this -> sessionid = $this -> createSessionId($this -> username, $this -> password);
		if(empty($_POST['remenberme'])){
			$this -> expiredtime = time()+3600000;
			setcookie('HERALD_USER_SESSION_ID', $this -> sessionid, $this -> expiredtime,'/');
		}else{
			$this -> expiredtime = time()+1000000000;
			setcookie('HERALD_USER_SESSION_ID', $this -> sessionid, $this -> expiredtime,'/');
		}	
		return $this -> addData();
	}
	private function createSessionId( $username, $password ){
		$session_id = $this -> phphash($username) + $this -> phphash($password) + rand() + time();
		return md5($session_id);
	}
	private function phphash($str){		
		$seed=31;
		$hash=0;
		for ($i = 0; $i < strlen($str); $i++){
			$hash = $hash * $seed + ord($str[$i]);
		}
		return $hash & 0x7fffffff;

	}
	private function addData(){
		if($this -> isUserExist()){
			$sql_a = "UPDATE `herald_user` SET `login_times`=`login_times`+1 WHERE `card_num`='".$this -> username."'";
			mysql_query($sql_a);
			$sql_b = "INSERT INTO `herald_session` (session_id, ip, login_time, expired_time, user_id) VALUES ('".$this -> sessionid."', '127.0.0.1', '".time()."', '".$this -> expiredtime."','".$this -> username."')";
			mysql_query($sql_b);
		}else{
			$sql_a = "INSERT INTO `herald_user` (card_num, true_name, last_login_time, login_times) VALUES ('".$this -> username."', '".$this -> truename."', '".date('Y-m-d G:i:s')."', `login_times`+1)";
			$sql_b = "INSERT INTO `herald_session` (session_id, ip, login_time, expired_time, user_id) VALUES ('".$this -> sessionid."', '127.0.0.1', '".time()."', '".$this -> expiredtime."','".$this -> username."')";
			mysql_query($sql_a);
			mysql_query($sql_b);
		}
		if(mysql_errno()){
			mysql_query('rollback');
			return "sqlerror";
		}else{
			mysql_query('commit');
			return  "success";
		}
	}
	private function isUserExist(){
		$sql = "SELECT * FROM `herald_user` WHERE `card_num`='".$this -> username."' limit 1";
		$query = mysql_query($sql);
		if(mysql_fetch_array($query)){
			return true;
		}else{
			return false;
		}
	}
	private function isUserLogin(){
		$sql = "SELECT * FROM `herald_session` WHERE `session_id`='".$_COOKIE['HERALD_USER_SESSION_ID']."'";
		$query = mysql_query($sql);
		if($rs = mysql_fetch_array($query)){
			if($rs['ip'] == $_SERVER['REMOTE_ADDR'] && time() < $rs['expired_time'] && $rs['user_id'] == $this -> username){
				return true;
			}
		}
		return false;
	}
	public function htmlencode(&$str){
		if(empty($str))
			return;

		if($str=="") 
			return $str;
		$str=trim($str);
		$str=str_ireplace("&","&amp;",$str);
		$str=str_ireplace(" ","&nbsp;",$str);
		$str=str_ireplace(">","&gt;",$str);
		$str=str_ireplace("<","&lt;",$str);
		$str=str_ireplace(chr(32),"&nbsp;",$str);
		$str=str_ireplace(chr(9),"&nbsp;",$str);
		$str=str_ireplace(chr(34),"&",$str);
		$str=str_ireplace(chr(39),"&#39;",$str);
		$str=str_ireplace(chr(13),"<br />",$str);
		$str=str_ireplace("'","&#039;",$str);
		$str=str_ireplace("select","sel&#101;ct",$str);
		$str=str_ireplace("join","jo&#105;n",$str);
		$str=str_ireplace("union","un&#105;on",$str);
		$str=str_ireplace("where","wh&#101;re",$str);
		$str=str_ireplace("insert","ins&#101;rt",$str);
		$str=str_ireplace("delete","del&#101;te",$str);
		$str=str_ireplace("update","up&#100;ate",$str);
		$str=str_ireplace("like","lik&#101;",$str);
		$str=str_ireplace("drop","dro&#112;",$str);
		$str=str_ireplace("create","cr&#101;ate",$str);
		$str=str_ireplace("modify","mod&#105;fy",$str);
		$str=str_ireplace("rename","ren&#097;me",$str);
		$str=str_ireplace("alter","alt&#101;r",$str);
		$str=str_ireplace("cast","ca&#115;",$str);
		return $str;
	}
}