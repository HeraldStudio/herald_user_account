<?php
require_once 'LoginAction.class.php';
if(!empty($_POST['username']) && !empty($_POST['password'])){
	$user = new LoginAction();
	$user -> main();
}else{
	echo "用户名或密码为空";
}
