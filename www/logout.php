<?php	//脚本13-6 - logout.php
//这是登出页面，它会删除cookie。
//定义页面标题并包含头文件：
define('TITLE', 'Logout');
include('templates/header.html');

//如果session存在，则删除：
if(isset($_SESSION[CNAME]) && ($_SESSION[CNAME] == 'CVALUE')) {
	session_destroy();
	$_SESSION = array();
}

//打印一条消息：
print '<p>You are now logged out.</p>
<p>Click <a href="home.php">here </a>to home page.</p>';

//包含页脚文件：
include('templates/footer.html');

?>