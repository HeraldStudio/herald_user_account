<?php
/**
*
*这个类获取当前的会话信息
*如果有用户登录 则返回用户信息
*如果没有用户登录，则返回false
*@author GuoGengrui <tairyguo@gmail.com>
*@copyright HeraldStudio SEU
*@version 1.0.0
*
*
*/
require_once 'DbConnectModel.class.php';

class GetSessionModel{
	function __construct(){
		DbConnectModel::startConnect();
	}
	function __destruct(){
		DbConnectModel::closeConnect();
	}
	public function getCurrentSession(){
		if(!empty($_COOKIE['HERALD_USER_SESSION_ID'])){
			$sql = "SELECT user_id FROM `herald_session` WHERE `session_id` = '".$_COOKIE['HERALD_USER_SESSION_ID']."' AND `ip`='".$_SERVER['REMOTE_ADDR']."' limit 1";
			$query = mysql_query($sql);
			if($rs = mysql_fetch_array($query,MYSQL_ASSOC)){
				$sql_a = "SELECT * FROM `herald_user` WHERE `card_num`='".$rs['user_id']."'";
				$query_a = mysql_query($sql_a);
				$userinfo = mysql_fetch_array($query_a,MYSQL_ASSOC);
				return json_encode($userinfo);
			}
			else{
				return false;
			}
		}else{
			return false;
		}
	}
	public function getUserSessionState($userid){
		$sql = "SELECT * FROM `herald_session` WHERE `user_id`='".$userid."'";
		
	}
}