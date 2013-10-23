<?php
/**
 *
 *This is herald user account class for get session.
 *Each APP can send a cookie value to this class and
 *get current login user information with json form, 
 *but if there is not user login , it return an error 
 *all return data format is json
 *
 *
 *@author Tairy <tairyguo@gmail.com>
 *@version 2.0
 *@copyright HeraldStudio SEU
 *
 **/

class GetSessionAction{
	private $cookie;
	private $meminstance;
	private $loginuserinfo;
	private $successinfo;
	private $errorinfo;

	function __construct(){
		$this -> cookie = $_POST['cookie'];
		$this -> cheakPostData;
		$this -> meminstance = new Memcache();
		$this -> meminstance -> pconnect('localhost', 11211);
	}

	public function getLoginUserInfo(){
		$this -> getUserInfoByCookie();
		if($this -> loginuserinfo){
			$this -> successinfo['code'] = 200;
			$this -> successinfo['message'] = "已有用户登录";
			$this -> successinfo['data'] = $this -> loginuserinfo;
			echo json_encode($this -> successinfo);
		}else{
			$this -> successinfo['code'] = 404;
			$this -> successinfo['message'] = "没有用户登录";
			echo json_encode($this -> successinfo);
		}
	}

	private function getUserInfoByCookie(){
		$this -> loginuserinfo = $this -> meminstance -> get($this -> cookie);
	}

	private function cheakPostData(){
		if(empty($this -> cookie)){
			$this -> errorinfo['code'] = 1;
			$this -> errorinfo['type'] = "Bad data post";
			$this -> errorinfo['message'] = "No cookie error";
			echo json_encode($this -> errorinfo);
			return;
		}
	}
}