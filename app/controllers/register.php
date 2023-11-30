<?php

class Register extends Controller
{
	private $model;

    public function __construct()
	{
		$this->model = $this->model("registerModel");
    }

	public function render()
	{
		$this->view("auth_layout", [
			"page"=> 'register',
			"provinces" => $this->model->getProvinces(),
		]);
	}

	public function register()
	{
		if (isset($_POST['submit'])) {
			if (empty($_POST['name'])) {
				header('Location: index.php?page=register');
			} elseif (empty($_POST['email'])) {
				header('Location: index.php?page=register');
			} elseif (empty($_POST['password'])) {
				header('Location: index.php?page=register');
			} else {
				$name = $_POST['name'];
				$username = $_POST['email'];
				$password = $_POST['password'];
				$province = $_POST['province'];
				$district = $_POST['district'];
				$ward = $_POST['ward'];
				$password = password_hash($password, PASSWORD_DEFAULT);
				$registerResult = $this->model->register($name, $username, $password, $province, $district, $ward);

				$this->view("auth_layout", [
					"page"=> 'register',
					'result' => $registerResult,
				]);
			}
		}
	}

	public function fetchProvinces()
    {
		return $this->model->getProvinces();
    }



	public function fetchDistricts()
    {
		if (isset($_POST['province'])) {
			$districts = $this->model->getDistricts($_POST['province']);
			
			$output = '<option value="">Select district</option>';
			while ($district = mysqli_fetch_assoc($districts)) {
				$output .= '<option value="'. $district['code'] .'">'. $district['name_en'] .'</option>';
			}

			echo json_encode($output);
		} else {
			// Handle the case where no category is selected
			echo json_encode("No province is selected!");

		}
    }

	public function fetchWards()
    {
		if (isset($_POST['district'])) {
			$wards = $this->model->getWards($_POST['district']);
			
			$output = '<option value="">Select ward</option>';
			while ($ward = mysqli_fetch_assoc($wards)) {
				$output .= '<option value="'. $ward['code'] .'">'. $ward['name_en'] .'</option>';
			}

			echo json_encode($output);
		} else {
			// Handle the case where no category is selected
			echo json_encode("No district is selected!");

		}
    }
}