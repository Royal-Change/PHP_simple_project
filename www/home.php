<?php	//脚本13-11 - index.php
/*这是网站的主页。包含以下内容：
- 最新名人名言（默认）
- 或，随机名人名言
- 或，随机受欢迎的名人名言 */

//包含页头文件：
include('templates/header.html');

//再次创建session:
if(is_administrator()) {
	session_name(CNAME);
	session_set_cookie_params(time()+900);
	session_start();
	print session_name();
}

//包含数据库连接：
//创建数据库连接对象：
include('../mysql_conn.php');
$server = new mysql_conn();

//定义查询。。。。
//根据URL传递过来的值更改查询方式：
if(isset($_GET['random'])) {
	$query = "SELECT quote_id, quote, source, favorite from quotes order by rand() DESC LIMIT 1";
}elseif(isset($_GET['favorite'])) {
	$query = "SELECT quote_id, quote, source, favorite from quotes where favorite = 1 order by rand() DESC LIMIT 1";
}else {
	$query = "SELECT quote_id, quote, source, favorite from quotes order by data_entered DESC LIMIT 1";
}

//运行查询：
if($r = $server->doQuery($query, $server->conn)) {
	
	//返回查询结果：
	$row = mysql_fetch_array($r);
	
	//打印查询结果：
	print "<div><blockquote>{$row['quote']}</blockquote>- {$row['source']}";
	
	//判断是否为受欢迎的？
	if($row['favorite'] == 1) {
		print ' <b>Favorite!</b>';
	}
	
	//完成div标签：
	print '</div>';
	
	//如果管理员登录，显示管理员链接：
	if(is_administrator()) {
		print "<p><b>Quote Admin:</b> <a href=\"edit_quote.php?id={$row['quote_id']}\">Edit</a> <-> 
		<a href=\"delete_quote.php?id={$row['quote_id']}\">Delete</a></p>\n";
	}
	
}else {	//没有运行查询。
	if(is_administrator()) {
		print '<p class="error">Could not retrieve the data because: <br/>' . mysql_error($server->conn) . '</p>
		<p>The query being run was: ' . $query . '</p>';
	}
}	//结束查询条件语句。

$server->close();	//关闭连接。

print '<p><a href="home.php">Latest</a> <-> <a href="home.php?random=true">Random</a> <-> <a href="home.php?favorite=true">Favorite</a></p>';

if(!is_administrator()) {
	print '<p>Click <a href="login.php">here </a>to log in.</p>';
}

include('templates/footer.html');	//包含页脚文件。
?>
	