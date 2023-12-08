<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class RegisterModel extends Database
{
	public function checkDuplicateEmail($email){
		$sql = "SELECT * FROM users WHERE email = '$email'";
		return mysqli_query($this->connection, $sql);
	}
	public function register($name, $email, $hashed_password, $role){
		$sql = "INSERT IGNORE INTO users (name, email, pwd, role)
			VALUES  ('$name', '$email', '$hashed_password', '$role')";
		return mysqli_query($this->connection, $sql);
	}
}