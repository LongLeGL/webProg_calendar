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
		$this->view("register");
	}

	public function register()
	{
		$name = $email = $password = "";
		$email_err = $password_err = $login_err = "";
	
		// Check if the form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$email = $_POST["email"];
			$password = $_POST["password"];
			$name = $_POST["name"];
			$role = $_POST["role"];
	
	
			// Check if the query returned a row
			if (mysqli_num_rows(($this->model->checkDuplicateEmail($email))) > 0) {
				$_SESSION['emailduplicate'] = true;
				header("Location: index.php?page=register");
				exit;
			}
	
			$hashed_password = password_hash($password, PASSWORD_DEFAULT);

			$_SESSION['emailduplicate'] = $this->model->register($name, $email, $hashed_password, $role);
	
			header("Location: index.php?page=login");
		}
		
	}
}