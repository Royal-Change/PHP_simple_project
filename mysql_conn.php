<?php	//创建MySQl连接。
class mysql_conn {
	public $conn;
	public $result;
	
	private $query='<p>The query being run was: ';
	
	public function __construct($serverName='localhost', $userName='root', $password='root') {	//数据库登录
		if(!$this->conn) {
			$this->conn = mysql_connect($serverName , $userName, $password);	//创建连接。
			mysql_select_db('webapp', $this->conn);	//选中数据库。
		}
	}
		
	public function doQuery($sql) {
		if(!$this->conn) {	//无法连接到服务器。
			print '<p style="color:red;">Could not connect to target database because: <br/>' .
			mysql_error($this->conn) . '</p>';
		}
		if($sql) {
			$this->sql = $sql;
		}
		if($this->result = mysql_query($this->sql, $this->conn)) {	//获得返回数据。
			return $this->result;
		}else {	//无法获取句柄。
			print '<p style="color:red;">Could not retrieve data from target database because: <br/>' .
			print_r(iconv('gbk', 'utf-8' ,mysql_error($this->conn))) . '</p>' . $query . $this->sql . '</p>';
		}
	}
	
	public function close() {
		mysql_close($this->conn);	//关闭连接。
	}
}	//完成类。
?>