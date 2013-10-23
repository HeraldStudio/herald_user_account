<?php
require 'Lib/LoginActionClass.php';

$LoginAction = new LoginAction($_POST['username'], $_POST['password']);
$LoginAction -> login();