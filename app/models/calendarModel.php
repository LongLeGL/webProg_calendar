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
					a.id,
					a.start,
					a.end,
					a.patientId,
					COALESCE(u_patient.name, NULL) AS patientName,
					a.doctorId,
					u_doctor.name AS doctorName,
					a.status
				FROM 
					appointments AS a
				LEFT JOIN 
					users AS u_patient ON a.patientId = u_patient.id AND u_patient.role = 'patient'
				JOIN 
					users AS u_doctor ON a.doctorId = u_doctor.id AND u_doctor.role = 'doctor'
				WHERE 
					a.doctorId = '{$doctorId}'";

		return mysqli_query($this->connection, $sql);
	}

	public function getPendingEventByPatientId(){
		$now = date('Y-m-d H:i');

		$sql = "SELECT 
					a.id,
					a.start,
					a.end,
					a.patientId,
					u_patient.name AS patientName,
					a.doctorId,
					u_doctor.name AS doctorName,
					a.status
				FROM 
					appointments AS a
				LEFT JOIN 
					users AS u_patient ON a.patientId = u_patient.id AND u_patient.role = 'patient'
				JOIN 
					users AS u_doctor ON a.doctorId = u_doctor.id AND u_doctor.role = 'doctor'
				WHERE 
					patientId = '{$_SESSION['currentUser']['id']}' AND start > '{$now}'";

		return mysqli_query($this->connection, $sql);
}

	public function insert($id, $start, $end, $patientId, $doctorId, $status){
        $sql = "INSERT 
					INTO appointments (id, start, end, patientId, doctorId, status) 
					VALUES ('$id', '$start', '$end', '$patientId', '$doctorId', '$status')";
		 return mysqli_query($this->connection, $sql);
    }

	public function getEventByDateTime($start, $end){
		$sql = "SELECT COUNT(*) AS count FROM appointments 
				WHERE ('{$start}' BETWEEN start AND end)
					OR ('{$end}' BETWEEN start AND end)";

		return mysqli_query($this->connection, $sql);
    }
	
	public function delete($id){
        $sql = "DELETE FROM appointments WHERE id = '{$id}'";
		return mysqli_query($this->connection, $sql);
    }
}

?>