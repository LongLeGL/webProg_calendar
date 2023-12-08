<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class LoginModel extends Database
{
	public function login($email){
		$sql = "SELECT * FROM users WHERE email = '$email'";
		return mysqli_query($this->connection, $sql);
	}
}