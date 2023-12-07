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

<!-- <h2 style="text-align: center;">Login Form</h2> -->

<form action="./app/controllers/login_processing.php" method="post">
	<div class="imgcontainer">
		<img style="background-color: white;"  src="./app/views/auth_pages/img_avatar2.png" alt="Avatar" class="avatar">
	</div>

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
		<button type="button" class="cancelbtn">Cancel</button>
		<span  style="background-color: white;" class="psw">Forgot <a  style="background-color: white;" href="#">password?</a></span>
	</div>
</form>

</body>
</html>

<!-- <div class="row">
	<div class="col-12">
		<div class="mb-4">
			<h3>Sign in</h3>
			<p>Don't have an account? <a href="index.php?page=register">Sign up</a></p>
		</div>
	</div>
</div>
<form method="POST" action="index.php?page=login/login" novalidate="" autocomplete="off" onsubmit="return validateForm()">
<div class="row gy-3 overflow-hidden">
	<div class="col-12">
		<div class="form-floating mb-3">
			<input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
			<label for="email" class="form-label">Email</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-floating mb-3">
			<input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
			<label for="password" class="form-label">Password</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-check">
			<input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
			<label class="form-check-label text-secondary" for="remember_me">
			Keep me logged in
			</label>
		</div>
	</div>
	<div class="col-12">
		<div class="d-grid">
			<button class="btn btn-primary btn-lg" type="submit" name="submit">Log in now</button>
		</div>
	</div>
</div>
</form>
<div class="row">
	<div class="col-12">
		<div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
		<a href="#!">Forgot password</a>
		</div>
	</div>
</div>

<script>
    (function () {
	'use strict'

	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	var forms = document.querySelectorAll('.needs-validation')

	// Loop over them and prevent submission
	Array.prototype.slice.call(forms)
		.forEach(function (form) {
		form.addEventListener('submit', function (event) {
			if (!form.checkValidity()) {
			event.preventDefault()
			event.stopPropagation()
			}

			form.classList.add('was-validated')
		}, false)
		})
	})()
</script> -->