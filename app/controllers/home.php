<?php

class Home extends Controller
{
	private $model;

    public function __construct(){
        $this->model = $this->model('homeModel');
    }

	public function render(){
		$this->view("master_layout", [
			'page' => 'home',
		]);
	}

	public function fetchEvents(){
		$events = $this->model->getEvents();

		$result = [];
		while ($row = mysqli_fetch_array($events)) { 
			$event = [
				'id' => $row['id'],
				'fullName' => $row['fullName'],
				'creatorId' => $row['creatorId'],
				'start' => $row['start'],
				'end' => $row['end'],
				'backgroundColor' => $row['backgroundColor'],
			];
		
			$result[] = $event;
		}
		echo json_encode($result);
    }

	public function insert($id, $fullName, $start, $end){
		if ($_SESSION['userLevel'] == 'doctor') {
			$result = $this->model->insert($id, 'Doctor is busy!', 'doctor', $start, $end, '#9e2642');
			echo json_encode($result);
		} 
		else {
			$result = $this->model->insert($id, $fullName, $_SESSION['username'], $start, $end, '#3788d8');
			echo json_encode($result);
		}
    }

	public function havePendingEvent(){
		$result = $this->model->getPendingEventByCurrentUser();
		$row = mysqli_fetch_assoc($result);

		echo json_encode($row["count"] > 0);
	}

	public function timeSlotIsAvailable($start, $end){
		$result = $this->model->getEventByDateTime($start, $end);
		$row = mysqli_fetch_assoc($result);

		echo json_encode($row["count"] == 0);
    }

	public function delete($id){
		$result = $this->model->delete($id);
		echo json_encode($result);
    }
}

?>