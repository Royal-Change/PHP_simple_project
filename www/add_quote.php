<?php	//脚本13-7 - add_quote.php
//脚本添加名人名言。

//定义页面标题并包含头文件：
define('TITLE', 'Add a Quote');
include('templates/header.html');

print '<h2>Add a Quotation</h2>';

//强制只有管理员可以访问该页面：
if(!is_administrator()) {
	print '<h2>Access Denied!</h2><p class="error">You do not have permission to access this page.</p>';
	include('templates/footer.html');
	exit();
}else {
	
	//再次创建session:
	session_name(CNAME);
	session_set_cookie_params(time()+900);
	session_start();
}

//检查表单是否提交：
if($_SERVER['REQUEST_METHOD'] == 'POST') {
	
	if(!empty($_POST['quote']) && !empty($_POST['source'])) {
		
		//包含数据库连接：
		include('../mysql_connect.php');
		
		//创建数据库对象：
		$server = new mysql_connect();
		
		//准备查询中使用的值：
		$quote = mysql_real_escape_string(trim(strip_tags($_POST['quote'])));
		$source = mysql_real_escape_string(trim(strip_tags($_POST['source'])));
		
		//创建favorite值：
		if(isset($_POST['favorite'])) {
			$favorite = 1;
		}else {
			$favorite = 0;
		}
		
		$query = "INSERT INTO quotes (quote, source, favorite, data_entered) VALUES ('$quote', '$source', '$favorite', NOW())";
		$r = mysql_query($query, $server->conn);
		
		if(mysql_affected_rows($server->conn) == 1) {
			//打印一条消息：
			print '<p>Your quotation has been stored.</p>';
		}else {
			print '<p class="error">Could not  store the quote because: <br/>' .
			mysql_error($server->conn) . '</p><p>The query being run was: ' . $query . '</p>';
		}
		
		//关闭连接：
		$server->close();
		
	}else {	//没有填写名人名言。
		print '<p class="error">Please  enter a quotation and a source!</p>';
	}
	
}	//结束提交条件语句。
//结束PHP节并显示表单。
?>

<form action="add_quote.php" method="post">
<p><label>Quote: <textarea name="quote" rows="5" cols="30"><?php
//粘性表单：
if(isset($_POST['quote'])) {
	print htmlspecialchars($_POST['quote']);
}
?></textarea></label></p>
<p><label>Source: <input type="text" name="source" value="<?php
//粘性表单：
if(isset($_POST['source'])) {
	print htmlspecialchars($_POST['source']);
}
?>" /></label></p>
<p><label>Is this a favorite? <input type="checkbox" name="favorite" value="yes" /></label></p>
<p><input type="submit" name="submit" value="Add This Quote!" /></p>
</form>

<?php	include('templates/footer.html');	//包含页脚文件。 ?> 