<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
*{
	background-color: #0082c8;
}
body {
	font-family: Arial, Helvetica, sans-serif; 
	/* height: 400px; */
	width: 400px;
	margin: auto;
	/* text-align: center; */
	margin-top: 30px;
	background-color: white;
}

form {
	border: 3px solid #f1f1f1;
	background-color: white;
}

.container label{
	background-color: white;
}

input[type=email], input[type=password], input[type=text] {
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

<h2 style="text-align: center; background-color: white; margin: auto; margin-top: 10px;">Register</h2>

<form action="index.php?page=register/register" method="post">
	<div class="imgcontainer">
		<img style="background-color: white;"  src="./public/images/img_avatar2.png" alt="Avatar" class="avatar">
	</div>

	<!-- <div class="warning">
		<label for="name"><b style="background-color: white;">Name</b></label>
	</div> -->

	<?php
		if(isset($_SESSION["emailduplicate"]) && $_SESSION["emailduplicate"] == true){
			echo '<div class="warning" style="background-color: red;>';
				echo '<label for="warning"><b style="background-color: red;">Email has been used, please use another email.</b></label>';
			echo '</div>';
		}
	?>

	<div class="container">
		<label for="name"><b style="background-color: white;">Name</b></label>
		<input type="text" placeholder="Enter your name" name="name" required>

		<label for="name"><b style="background-color: white;">Role</b></label>
		<input type="text" pattern="^(patient|doctor)$" placeholder="Enter 'patient' or 'doctor'" name="role" required>

		<label for="email"><b style="background-color: white;">Email</b></label>
		<input type="email" placeholder="Enter your email" name="email" required>

		<label for="psw"><b style="background-color: white;" >Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" 
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"
                required>
		<button type="submit">Register</button>
	</div>

	<div class="container" style="background-color:#f1f1f1">
		<a href='index.php?page=login'><button type="button" class="cancelbtn">Login</button></a>
	</div>
</form>

</body>
</html>