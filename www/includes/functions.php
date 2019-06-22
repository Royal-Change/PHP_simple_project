<?php	//脚本13-2 - functions.php
//脚本定义自定义函数。

//函数检查用户是否为管理员。
//函数接受两个可选参数。
//函数返回一个布尔值。

//将COOKIE名和值定义为常量：
define('CNAME', 'Samuel');
define('CVALUE', 'Clemens');

function is_administrator($name = CNAME, $value = CVALUE) {
	
	//检查cookie是否存在和cookie值：
	if(isset($_COOKIE[$name]) && ($_COOKIE[$name] == $value)) {
		return true;
	}else {
		return false;
	}
	
}	//结束is_administrator()函数。

?>