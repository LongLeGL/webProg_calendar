<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
class CalendarModel extends Database
{
	public function getDoctor($doctorId){
		$sql = "SELECT * FROM users WHERE id = '{$doctorId}'";
		return mysqli_query($this->connection, $sql);
	}
	

	public function getEvents($doctorId){
		$sql = "SELECT 
					e.id,
					e.start,
					e.end,
					e.patientId,
					COALESCE(u_patient.name, NULL) AS patientName,
					e.doctorId,
					u_doctor.name AS doctorName,
					e.status
				FROM 
					events AS e
				LEFT JOIN 
					users AS u_patient ON e.patientId = u_patient.id AND u_patient.role = 'patient'
				JOIN 
					users AS u_doctor ON e.doctorId = u_doctor.id AND u_doctor.role = 'doctor'
				WHERE 
					e.doctorId = '{$doctorId}'";

		return mysqli_query($this->connection, $sql);
	}

	public function getPendingEventByPatientId(){
		$now = date('Y-m-d H:i');

		$sql = "SELECT 
					e.id,
					e.start,
					e.end,
					e.patientId,
					u_patient.name AS patientName,
					e.doctorId,
					u_doctor.name AS doctorName,
					e.status
				FROM 
					events AS e
				LEFT JOIN 
					users AS u_patient ON e.patientId = u_patient.id AND u_patient.role = 'patient'
				JOIN 
					users AS u_doctor ON e.doctorId = u_doctor.id AND u_doctor.role = 'doctor'
				WHERE 
					patientId = '{$_SESSION['currentUser']['id']}' AND start > '{$now}'";

		return mysqli_query($this->connection, $sql);
}

	public function insert($id, $start, $end, $patientId, $doctorId, $status){
		$sql = "INSERT INTO events (id, start, end, patientId, doctorId, status) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($this->connection, $sql);
		mysqli_stmt_bind_param($stmt, "ssssss", $id, $start, $end, $patientId, $doctorId, $status);
		return mysqli_stmt_execute($stmt);
    }

	public function getEventCountByDateTime($start, $end){
		$sql = "SELECT * FROM events 
				WHERE ('{$start}' BETWEEN start AND end)
					OR ('{$end}' BETWEEN start AND end)";

		return mysqli_query($this->connection, $sql);
    }

	public function getEventByDateTime($start, $end){
		$sql = "SELECT 
					e.id,
					e.start,
					e.end,
					e.patientId,
					COALESCE(u_patient.name, NULL) AS patientName,
					e.doctorId,
					u_doctor.name AS doctorName,
					e.status
				FROM 
					events AS e
				LEFT JOIN 
					users AS u_patient ON e.patientId = u_patient.id AND u_patient.role = 'patient'
				JOIN 
					users AS u_doctor ON e.doctorId = u_doctor.id AND u_doctor.role = 'doctor'
				WHERE 
					e.doctorId = '{$_SESSION['currentUser']['id']}' 
					AND '{$start}' <= e.start
            		AND '{$end}' >= e.end";

		return mysqli_query($this->connection, $sql);
    }
	
	public function delete($id){
        $sql = "DELETE FROM events WHERE id = '{$id}'";
		return mysqli_query($this->connection, $sql);
    }

	public function getOccupiedTimeSlotsByDoctorAndDate($doctorId, $date){
        $sql = "SELECT TIME(start), TIME(end) FROM events WHERE DATE(start) = '{$date}' AND doctorId = '{$doctorId}'";
		$result = mysqli_query($this->connection, $sql);
		echo json_encode($result);
    }
}

?>