<?php	//脚本13-8 - view_quotes.php
//脚本显示所有名人名言。

//定义页面标题并包含页头文件：
define('TITLE', 'View All Quotes');
include('templates/header.html');

print '<h2>All Quotes</h2>
<p>排序：<select id="sort" onchange="reloc()">
<option value="DESC" ';

//显示当前排序方式：
if($_GET['sort'] == 'DESC') {
	print 'selected="selected"';
}
print ' >降序</option>
<option value="ASC" ';

if($_GET['sort'] == 'ASC') {
	print 'selected="selected"';
}

print ' >升序</option></select></p>';

print "\n";

//强制只有管理员可以访问该页面：
if(!is_administrator()) {
	print '<h2>Access Denies!</h2><p class="error">You do not have permission to access this page.</p>';
	include('templates/footer.html');
	exit();
}else {
	//再次创建session:
	session_name(CNAME);
	session_set_cookie_params(time()+1800);
	session_start();
}

//包含数据库连接：
//创建连接对象：
include('../mysql_conn.php');
$server = new mysql_conn();

//对排序参数预处理：
if(strtoupper($_GET['sort']) == 'DESC') {
	$sort = 'DESC';
}elseif(strtoupper($_GET['sort']) == 'ASC') {
	$sort = 'ASC';
}else {
	$sort = '';
	print '<p class="error">Invalid sort!</p>';
	include('templates/footer.html');
	exit();
}

//定义查询：
$query = "SELECT quote_id, quote, source, favorite from quotes order by data_entered $sort";

//运行查询：
if($r = $server->doQuery($query, $server->conn)) {
	
	//返回查询结果：
	while($row = mysql_fetch_array($r)) { 
	
		//打印查询结果：
		print "<div><blockquote>{$row['quote']}</blockquote>- {$row['source']}\n";
		
		//判断是否为受欢迎的。
		if($row['favorite'] == 1) {
			print ' <b>Favorite!</b>';
		}
		
		//添加管理员链接：
		print "<p><b>Quote Admin: </b><a href=\"edit_quote.php?id={$row['quote_id']}\">Edit</a>
		 <-> 
		<a href=\"delete_quote.php?id={$row['quote_id']}\">Delete</a></p></div>\n";
		
	}	//结束循环。
	
}else {	//没有运行查询。
	print '<p class="error">Could not retrieve the data because: <br/>' . 
	mysql_error($server->conn) . '</p><p>The query being run was: ' . $query . '</p>';
}	//结束查询条件语句。

$server->close();	//关闭连接。

include('templates/footer.html');	//包含页脚文件。

?>