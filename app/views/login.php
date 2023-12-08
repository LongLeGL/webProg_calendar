<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{
	background-color: #0082c8;
}
body {
	font-family: Arial, Helvetica, sans-serif; 
	height: 500px;
	width: 400px;
	margin: auto;
	/* text-align: center; */
	margin-top: 70px;
	background-color: white;
}

form {
	border: 3px solid #f1f1f1;
	background-color: white;
}

.container label{
	background-color: white;
}

input[type=email], input[type=password] {
	width: 100%;
	padding: 12px 20px;
	margin: 8px 0;
	display: inline-block;
	border: 1px solid #ccc;
	box-sizing: border-box;
	background-color: white;
}

button {
	background-color: #04AA6D;
	color: white;
	padding: 14px 20px;
	margin: 8px 0;
	border: none;
	cursor: pointer;
	width: 100%;
}

button:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
	background-color: white;
  
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
	background-color: white;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>

<form action="index.php?page=login/login" method="post">
	<div class="imgcontainer">
		<img style="background-color: white;"  src="./public/images/img_avatar2.png" alt="Avatar" class="avatar">
	</div>

	<?php
		if(isset($_SESSION["uncorrectemail"]) && $_SESSION["uncorrectemail"] == true){
			echo '<div class="warning" style="background-color: red;>';
				echo '<label for="warning"><b style="background-color: red;">Email is incorrect</b></label>';
				echo $_SESSION["uncorrectemail"];
			echo '</div>';
		}

		else if(isset($_SESSION["uncorrectpassword"]) && $_SESSION["uncorrectpassword"] == true){
			echo '<div class="warning" style="background-color: red;>';
				echo '<label for="warning"><b style="background-color: red;">Password is incorrect</b></label>';
			echo '</div>';
		}
	?>
	<div class="container">
		<label for="email"><b style="background-color: white;">Email</b></label>
		<input type="email" placeholder="Enter your email" name="email" required>

		<label for="psw"><b style="background-color: white;" >Password</b></label>
		<!-- <input type="password" placeholder="Enter Password" name="password" 
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"
                required> -->
		<input type="password" placeholder="Enter Password" name="password" required>
		<button type="submit">Login</button>
		<!-- <label>
		<input type="checkbox" checked="checked" name="remember"> Remember me
		</label> -->
	</div>

	<div class="container" style="background-color:#f1f1f1">
		<a href='index.php?page=register'><button type="button" class="cancelbtn">Register</button></a>
		<!-- <span  style="background-color: white;" class="psw">Forgot <a  style="background-color: white;" href="#">password?</a></span> -->
	</div>
</form>

</body>
</html>