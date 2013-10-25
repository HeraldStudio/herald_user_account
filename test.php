<?php
$url = "http://121.248.63.105:8000/useraccount/login.html?redirecturl=http://herald.seu.edu.cn";
$test = parse_url($url);
print_r($test);