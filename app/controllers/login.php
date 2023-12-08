<?php

class Login extends Controller
{
	private $model;

    public function __construct()
	{
		$this->model = $this->model("loginModel");
    }

	public function render()
	{
		$this->view("login");
	}

	public function login()
	{
		$email = $password = "";
		$email_err = $password_err = $login_err = "";

		// Check if the form is submitted
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			$email = $_POST["email"];
			$password = $_POST["password"];

			$result = $this->model->login($email);
			// Check if the query returned a row
			if ($result->num_rows > 0) {
				$row = mysqli_fetch_assoc($this->model->login($email));
				$stored_password = $row["pwd"];
				if (password_verify($password, $stored_password)) {
					$_SESSION['currentUser']['id'] = $row["id"];
					$_SESSION['currentUser']['name'] = $row["name"];
					$_SESSION['currentUser']['email'] = $row["email"];
					$_SESSION['currentUser']['role'] = $row["role"];

					$_SESSION['uncorrectpassword'] = false;
					$_SESSION['uncorrectemail'] = false;

					
					if ($row["role"] == 'patient')  header("Location: index.php?page=home");
					else header("Location: index.php?page=calendar/" . $row["id"]);
					
					exit;
				}
				else {
					$_SESSION['uncorrectemail'] = false;
					$_SESSION['uncorrectpassword'] = true;

					header("Location: index.php?page=login.php");

					exit;
				}
			}

			$_SESSION['uncorrectemail'] = true;
			header("Location: index.php?page=login.php");
		}
	}

	public function logout() {
		$_SESSION = array();
		session_destroy();
		
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie("user", '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
		}

		exit;
	}
}