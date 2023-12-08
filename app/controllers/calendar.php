<?php

class Calendar extends Controller
{
	private $model;

    public function __construct(){
        $this->model = $this->model('calendarModel');
    }

	public function render($docId){
		if ($_SESSION['currentUser']['role'] == 'patient'){
			$_SESSION['currentUser']['doctorId'] = $docId;
		} else {
			$_SESSION['currentUser']['doctorId'] = $_SESSION['currentUser']['id'];
		}

		$data = [
			'page' => 'calendar',
		];

		if ($_SESSION['currentUser']['role'] == 'patient') {
			$data['doctor'] = $this->getDoctor();
		}

		$this->view("master_layout", $data);
    }

	public function getDoctor(){
		$result = $this->model->getDoctor($_SESSION['currentUser']['doctorId']);
		return mysqli_fetch_assoc($result);
	}

	public function fetchEvents(){
		$events = $this->model->getEvents($_SESSION['currentUser']['doctorId']);

		$result = [];
		while ($row = mysqli_fetch_array($events)) { 
			$event = [
				'id' => $row['id'],
				'start' => $row['start'],
				'end' => $row['end'],
				'patientId' => $row['patientId'],
				'patientName' => $row['patientName'],
				'doctorId' => $row['doctorId'],
				'doctorName' => $row['doctorName'],
				'status' => $row['status'],
			];
		
			$result[] = $event;
		}
		echo json_encode($result);
    }

	public function insert(){
		$json_data = file_get_contents("php://input");
		$data = json_decode($json_data, true);
		
		if (isset($data['id']) && isset($data['start']) && isset($data['end'])) {
			if ($_SESSION['currentUser']['role'] == 'doctor') {
				$result = $this->model->insert($data['id'], $data['start'], $data['end'], null, $_SESSION['currentUser']['id'], 'confirmed');
				return json_encode($result);
			} 
			else {
				$result = $this->model->insert($data['id'], $data['start'], $data['end'], $_SESSION['currentUser']['id'], $_SESSION['currentUser']['doctorId'], 'pending');
				return json_encode($result);
			}
		}
    }

	public function getPendingEvent(){
		$result = $this->model->getPendingEventByPatientId();
		$row = mysqli_fetch_assoc($result);

		echo json_encode($row);
	}

	public function checkTimeSlot($start, $end){
		$result = $this->model->getEventCountByDateTime($start, $end);

		echo json_encode(mysqli_num_rows($result) == 0);
    }

	public function getEventByDateTime($start, $end){
		$events = $this->model->getEventByDateTime($start, $end);

		$result = [];
		while ($row = mysqli_fetch_array($events)) { 
			$event = [
				'id' => $row['id'],
				'start' => $row['start'],
				'end' => $row['end'],
				'patientId' => $row['patientId'],
				'patientName' => $row['patientName'],
				'doctorId' => $row['doctorId'],
				'doctorName' => $row['doctorName'],
				'status' => $row['status'],
			];
		
			$result[] = $event;
		}
		echo json_encode($result);
    }

	public function delete(){
		$json_data = file_get_contents("php://input");
		$data = json_decode($json_data, true);
		
		if (isset($data['id'])) {
			$result = $this->model->delete($data['id']);
			return json_encode($result);
		}
    }

	public function getOccupiedTimeSlotsByDoctorAndDate(){
		$json_data = file_get_contents("php://input");
		$data = json_decode($json_data, true);
		
		if (isset($data['doctorId']) && isset($data['date'])) {
			$result = $this->model->getOccupiedTimeSlotsByDoctorAndDate($data['doctorId'], $data['date']);
			return json_encode($result);
		}
	}
}

?>