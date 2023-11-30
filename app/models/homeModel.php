<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class HomeModel extends Database
{
	public function getAll(){
		$sql = "SELECT
					id,
					fullName,
					DATE_FORMAT(date, '%M %e, %Y') AS date,
					TIME_FORMAT(startTime, '%h:%i:%s') AS startTime,
					creatorId
				FROM
					appointments";
		return mysqli_query($this->connection, $sql);
	}

	public function insert($id, $fullName, $date, $startTime, $creatorId){
        $sql = "INSERT 
					INTO appointments 
							(id, fullName, date, startTime, creatorId) 
					VALUES ('$id', '$fullName', '$date', '$startTime', '$creatorId')";
		$result = false;
		if (mysqli_query($this->connection, $sql)) {
			$result = true;
		}
		return $result;
    }

	public function isAvailableTimeSlot($date, $inputStartTime){
		// Calculate the end time by adding 30 minutes to the input start time
		$inputEndTime = date('H:i', strtotime($inputStartTime) + 30 * 60);

		// Case 1: Check from client side to database
		$sql = "SELECT COUNT(*) AS count FROM appointments WHERE startTime BETWEEN {$inputStartTime} AND {$inputEndTime}";
		$result = mysqli_query($this->connection, $sql);
		$row = mysqli_fetch_assoc($result);

		if ($row['count'] > 0){
			return false;
		}

		// Case 2: Check from database to client side
		$today = date('Y-m-d');
		$sql = "SELECT * FROM appointments WHERE DATE >= {$today}";
		$result = mysqli_query($this->connection, $sql);

		while ($row = mysqli_fetch_assoc($result)) {
			// Generate end time from start time
			$endTimeFromDb = date('H:i', strtotime($row['startTime']) + 30 * 60);

			// Check if inputStartTime is between the generated range
			if ($inputStartTime >= $row['startTime'] && $inputStartTime <= $endTimeFromDb) {
				return false;
			}
		}

		return true;
    }

	public function checkUnexpiredEvent(){
			$_SESSION['message'] = 'checkUnexpiredEvent func in Model called!';
			$currentDate = date('Y-m-d');
			$currentTime = date('H:i');
	
			$sql = "SELECT COUNT(*) AS count FROM appointments
					WHERE creatorId = {$_SESSION['username']}
					AND date >= {$currentDate}
					AND (date > {$currentDate} OR (date = {$currentDate} AND time >= {$currentTime}))";
	
			$result = mysqli_query($this->connection, $sql);
			$row = mysqli_fetch_assoc($result);
	
			echo json_encode(['checkUnexpiredEvent' => $row["count"] > 0]);
	}
	
	
}

?>