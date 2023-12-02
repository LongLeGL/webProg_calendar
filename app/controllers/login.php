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
		$this->view("auth_layout", [
			"page"=> 'login',
		]);
	}

	private function validate($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
	
		return $data;
	}

	public function login()
	{
		$result = false;

		if (isset($_POST['submit'])) {
			$username = $this->validate($_POST['email']);
			$password_input = $this->validate($_POST['password']);

			$result = $this->model->login($username);

			if (mysqli_num_rows($result)) {
				while ($row = mysqli_fetch_array($result)) {
					$id = $row['id'];
					$username = $row['username'];
					$password = $row['password'];
					$name = $row['name'];
					$province = $row['province'];
					$district = $row['district'];
					$ward = $row['ward'];

				}
				if (password_verify($password_input, $password)) {
					setcookie("id", $id, time() + 3600, "/");
					setcookie("username", $username, time() + 3600, "/");
					setcookie("name", $name, time() + 3600, "/");
					setcookie("province", $province, time() + 3600, "/");
					setcookie("district", $district, time() + 3600, "/");
					setcookie("ward", $ward, time() + 3600, "/");
					$_SESSION['authenticated'] = true;
					// $_SESSION['authenticated']["user_level"] = $user_level;

					header('Location: index.php?page=calendar');
				}
				else {
					$this->view("auth_layout", [
						"page"=> 'login',
					]);
				}
			}
		}
	}

	public function logout() {
		unset($_SESSION['authenticated']);
		if (isset($_COOKIE["username"])){
			setcookie("username", '', time() - (3600));
			setcookie("id", '', time() + 3600, "/");
			setcookie("name", '', time() + 3600, "/");
			setcookie("province", '', time() + 3600, "/");
			setcookie("district", '', time() + 3600, "/");
			setcookie("ward", '', time() + 3600, "/");
		}
		header('Location: index.php?page=calendar');
	}
}