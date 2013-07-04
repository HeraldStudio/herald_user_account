<?php
require_once './Lib/GetSessionModel.class.php';
$Session = new GetSessionModel();

$result = $Session -> getCurrentSession();
if(!$result){
?>
<!DOCTYPE html>
<html lang="zh" class="login_page">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login Page</title>
    <link href="./Css/bootstrap/bootstrap.css" rel="stylesheet" media="screen"> 
	<link href="./Css/bootstrap/bootstrap-combine.css" rel="stylesheet" media="screen"> 
	
	<style>
	.center {
		width: auto;
		display: table;
		margin-left: auto;
		margin-right: auto;
			}
	.text-center {
		text-align: center;
		}
	</style>
    </head>
    <body style="background-image:url(./Images/noise-all.png)">
		
 <div class="container center well" style="margin-top:150px;">  
    <form type="submit" action="./Lib/index.php" method="post">
       
          <label class="control-label" for="inputUsername">用户名（一卡通）</label>   
             <input type="text" id="inputUsername" name="username">
			<label class="control-label" for="inputPassword">密码</label>
				<input type="password" id="inputPassword" name="password">
				<label class="checkbox">
					<input type="checkbox" name="rememberme"> Remember me
				</label>
				<button type="submit" class="btn btn-success center">登录</button>
    </form>
 </div>
			
    </body>
</html>
<?php
}else{
	echo "已有账号登录请退出";
}
?>