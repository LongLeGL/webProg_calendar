<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class HomeModel extends Database
{
	public function getEvents(){
		$sql = "SELECT * FROM appointments";
		return mysqli_query($this->connection, $sql);
	}

	public function getPendingEventByCurrentUser(){
		$now = date('Y-m-d H:i');

		$sql = "SELECT COUNT(*) AS count FROM appointments 
				WHERE creatorId = '{$_SESSION['username']}' AND start > '{$now}'";

		return mysqli_query($this->connection, $sql);
}

	public function insert($id, $fullName, $creatorId, $start, $end, $backgroundColor){
        $sql = "INSERT 
					INTO appointments (id, fullName, creatorId, start, end, backgroundColor) 
					VALUES ('$id', '$fullName', '$creatorId', '$start', '$end', '$backgroundColor')";
		if (mysqli_query($this->connection, $sql)) {
			return true;
		}
		return false;
    }

	public function getEventByDateTime($start, $end){
		$sql = "SELECT COUNT(*) AS count FROM appointments 
				WHERE ('{$start}' BETWEEN start AND end)
					OR ('{$end}' BETWEEN start AND end)";

		return mysqli_query($this->connection, $sql);
    }
	
	public function delete($id){
        $sql = "DELETE FROM appointments WHERE id = '{$id}'";
		if (mysqli_query($this->connection, $sql)) {
			return true;
		}
		return false;
    }
}

?>