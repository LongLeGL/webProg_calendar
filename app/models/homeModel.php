
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class HomeModel extends Database
{
	public function getDoctors(){
		$sql = "SELECT * FROM users WHERE role LIKE 'doctor'";
		return mysqli_query($this->connection, $sql);
	}
}