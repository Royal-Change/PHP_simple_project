<?php	//脚本13-5 - login.php
//页面用于用户登录网站。

//设置页面标题并包含头文件：
define('TITLE','Login');
include('templates/header.html');

//检查表单是否已提交：
if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_SESSION['CNAME'])) {
	
	//处理表单：
	if(!empty($_POST['email']) && !empty($_POST['password'])) {
		
		if((strtolower($_POST['email']) == 'me@example.com') && ($_POST['password'] == 'testpass')) {	//用户名和密码正确。
			
			//登录成功：
			$loggedin = TRUE;
			
			//开启session缓冲流：
			session_name(CNAME);
			session_id(CVALUE);
			session_set_cookie_params(time()+900);
			session_start();
			setcookie(session_name(), session_id(),time()+900);
			$_SESSION['email'] = $_POST['email'];
			
			//打印一条信息：
			print '<p>You are now logged in!</p>';
			
		}else {	//不正确。
			$error = 'The submitted email address and password do not match those on file!';
		}
		
	}else {	//表单未填完整。
		$error = 'Please make sure you enter both and email address and a password';
	}
}elseif(!is_administrator()) {
	print '<h2>Login Form</h2>
	<form action="login.php" method="post">
	<p><label>Email Address: <input type="text" name="email" value="';
	if(isset($_SESSION['email'])) {
		print $_SESSION['email'];
	}
	print '" /></label></p>
	<p><label>Password: <input type="password" name="password" /></label></p>
	<p><input type="checkbox" name="rempass" value="true" />Remember the password</p>
	<p><input type="submit" name="submit" value="Log In!" /></p>
	</form>';
}else {
	print '<p>You already logged in.</p>';
}

//出现错误时打印错误信息：
if(isset($error)) {
	print '<p style="color:red;">' . $error . '</p>';
}

include('templates/footer.html');	//包含页脚文件。
?>