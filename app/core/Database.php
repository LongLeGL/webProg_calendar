<?php

class Database
{
	public $connection = 'home';
	protected $serverName = 'localhost';
	protected $username = 'root';
	protected $password = '';
	protected $dbname = 'ConvenientAppointment';

	public function __construct()
	{
		$this->connection = mysqli_connect($this->serverName, $this->username, $this->password);

		if (!$this->connection) {
			die("Connection failed: " . mysqli_connect_error());
		}

		mysqli_select_db($this->connection, $this->dbname);
		mysqli_query($this->connection, "SET NAMES 'utf8'");
	}
}

?>