<?php	//脚本13-9 - edit_quote.php
//脚本编辑名人名言。

//定义页面标题并包含页头文件：
define('TITLE', 'Edit a Quote');
include('templates/header.html');

print '<h2>Edit a Quotation</h2>';

//强制只有管理员可以访问该页面；
if(!is_administrator()) {
	print '<h2>Access Denied!</h2><p class="error">You do not have permissin to access this page.</p>';
	include('templates/footer.html');
	exit();
}else {
	//再次创建session:
	session_name(CNAME);
	session_set_cookie_params(time()+900);
	session_start();
}
//包含数据库连接：
include('../mysql_conn.php');
$server = new mysql_conn();

if(isset($_GET['id']) && is_numeric($_GET['id']) && ($_GET['id'] > 0)) {	//在一个表单内展示内容。
	
	//定义查询：
	$query = "SELECT quote, source, favorite from quotes where quote_id={$_GET['id']}";
	if($r = $server->doQuery($query, $server->conn)) {
		
		$row = mysql_fetch_array($r);	//返回信息。
		
		//创建表单：
		print '<form action="edit_quote.php" method="post">
		<p><label>Quote: <textarea name="quote" rows="5" cols="30">' . htmlspecialchars($row['quote']) . '</textarea></label></p>
		<p><label>Source: <input type="text" name="source" value="' . htmlspecialchars($row['source']) . '" /></label></p>
		<p><label>Is this a favorite? <input type="checkbox" name="favorite" value="yes"';
		
		//检查是否选中受欢迎复选框：
		if($row['favorite'] == 1) {
			print ' checked="checked"';
		}
		
		//完成表单：
		print ' /></label></p>
		<input type="hidden" name="id" value="' . $_GET['id'] . '" />
		<p><input type="submit" name="submit" value="Update This Quote!" /></p>
		</form>';
		
	}else {	//无法获取信息。
		print '<p class="error">Could not retrieve  the quotatioin because: <br/>' . mysql_error($server->conn) .
		'</p><p>The query being run was: ' . $query . '</p>';
	}
	
}elseif (isset($_POST['id']) && is_numeric($_POST['id']) && ($_POST['id'] > 0)) {	//处理表单。
	
	//验证表单数据并确保安全：
	$problem = FALSE;
	if(!empty($_POST['quote']) && !empty($_POST['source'])) {
		
		//准备查询中使用的值：
		$quote = mysql_real_escape_string(trim(strip_tags($_POST['quote'])));
		$source = mysql_real_escape_string(trim(strip_tags($_POST['source'])));
		
		//创建favorite值：
		if(isset($_POST['favorite'])) {
			$favorite = 1;
		}else {
			$favorite = 0;
		}
		
	}else {
		print '<p class="error">Please submit both a quotation and a source.</p>';
		$problem = TRUE;
	}
	
	if(!$problem) {
		
		//定义查询：
		$query = "UPDATE quotes SET quote='$quote', source='$source', favorite=$favorite where quote_id = {$_POST['id']}";
		if($r = $server->doQuery($query, $server->conn)) {
			print '<p>The quotatioin has been updated.</p>';
		}else {
			print '<p class="error">Could not update the quotatioin because: <br/>' . mysql_error($server->conn) . 
			'</p><p>The query being run was: ' . $query . '</p>';
		}
		
	}	//一切正常。
	
}else {	//没有获取id。
	print '<p class="error">This page has been accessed in error.</p>';
}	//结束提交条件语句。

$server->close();	//关闭连接。

include('templates/footer.html');	//包含页脚文件。
?>