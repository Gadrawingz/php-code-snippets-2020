<?php
include('db.config.php');

class SystemQuery
{
	public $dbconn;
	function __construct()
	{
		$obj = new DbConnectio;
		$this->dbconn = $obj->myConnection();
	}

	public function checkLogin(){
		$sql = "SELECT * FROM admins WHERE email = '".$_POST['email']."' && password= '".$_POST['password']."' ";
		$qry = $this->dbconn->prepare($sql);
		$qry->execute();
		return $qry;
	}

	public function insertAdmin($fname, $uname, $email, $pass) {
		$sql = "INSERT INTO admins VALUES(null, '".$fname."', '".$uname."', '".$email."', '".$pass."')";
		$query = $this->dbconn->prepare($sql);
		$query->execute();
		$count = $query->rowCount();
		return $count;
	}

	public function viewAdmins(){
		$qry = $this->dbconn->prepare("SELECT * FROM admins");
		$qry->execute();
		return $qry;
	}
}

?>
