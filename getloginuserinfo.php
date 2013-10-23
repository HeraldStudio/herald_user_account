<?php
require 'Lib/GetSessionActionClass.php';

$GetSessionAction = new GetSessionAction($_POST['cookie']);
$GetSessionAction -> getLoginUserInfo();