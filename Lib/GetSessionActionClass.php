<?php
class GetSessionAction{
	private $cookie;
	private $meminstance;
	private $loginuserinfo;

	function __construct($cookie){
		$this -> cookie = $cookie;
		$this -> meminstance = new Memcache();
		$this -> meminstance -> pconnect('localhost', 11211);
	}

	public function getLoginUserInfo(){
		$this -> getUserInfoByCookie();
		if($this -> loginuserinfo){
			echo $this -> loginuserinfo;
		}else{
			echo "OFFLINE";
		}
		
	}

	private function getUserInfoByCookie(){
		$this -> loginuserinfo = $this -> meminstance -> get($this -> cookie);
	}
}