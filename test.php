<?php
$meminstance = new Memcache();
$meminstance->pconnect('localhost', 11211);
$querykey = "sss";
$result = "sssddd";
$meminstance->set($querykey, $result, 0, 600);
$r = $meminstance->get($querykey);
print_r($r);
// mysql_connect("localhost", "root", "123456") or die(mysql_error());
// mysql_select_db("herald_league") or die(mysql_error());

// $query = "select * from `lg_league_info` where `heat` = 0";
// $querykey = "KEY" . md5($query);
// $session = "session";
// $meminstance->set($session, "ssssss", 0, 600);
// $result = $meminstance->get($querykey);
// $r = $meminstance->get($querykey);

// if (!$result) {
// 		  $query = mysql_query("select * from `lg_league_info` where `heat` = 0");
//        $result = mysql_fetch_array($query) or die('mysql error');
//        $meminstance->set($querykey, $result, 0, 600);
// print "got result from mysql\n";
// return 0;
// }

// print "got result from memcached\n";
// print_r($r);
// return 0;

?>