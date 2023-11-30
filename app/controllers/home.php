<?php

class Home extends Controller
{
	private $model;

    public function __construct()
	{
        $this->model = $this->model('homeModel');
    }

	public function render()
	{
		$this->view("master_layout", [
			'page' => 'home',
		]);
	}

	public function fetchEvents()
    {
		// if (isset($_POST['date']) && isset($_POST['time'])) {
		// 	return $this->model->isAvailableTimeSlot($_POST['date'], $_POST['time']);
		// }

		$events = $this->model->getAll();

		$result = [];
		while ($row = mysqli_fetch_array($events)) { 
			$event = [
				'id' => $row['id'],
				'fullName' => $row['fullName'],
				'date' => $row['date'],
				'startTime' => $row['startTime'],
				'creatorId' => $row['creatorId'],
			];
		
			$result[] = $event;
		}
		echo json_encode($result);
    }

	public function insert($id, $fullName, $date, $startTime)
    {
		$result = $this->model->insert($id, $fullName, $date, $startTime, $_SESSION['username']);
		if ($result) {
			$_SESSION['message'] = "New appointment is inserted successfully!";
			header('Location: index.php?page=home');
		} else {
			$_SESSION['message'] = 'New appointment insertion failed';
			header('Location: index.php?page=home');
		}
		return $result;
    }

	public function checkTimeSlot()
    {
		if (isset($_POST['date']) && isset($_POST['time'])) {
			return $this->model->isAvailableTimeSlot($_POST['date'], $_POST['time']);
		}
    }

	public function checkUnexpiredEvent()
	{
		return $this->model->checkUnexpiredEvent();
	}
}

?>