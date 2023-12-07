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

<form action="./app/controllers/register_processing.php" method="post">
	<div class="imgcontainer">
		<img style="background-color: white;"  src="img_avatar2.png" alt="Avatar" class="avatar">
	</div>

	<div class="container">
		<label for="name"><b style="background-color: white;">Name</b></label>
		<input type="text" placeholder="Enter your name" name="name" required>

		<label for="name"><b style="background-color: white;">Role</b></label>
		<input type="text" placeholder="Enter 'patient' or 'doctor'" name="role" required>

		<label for="email"><b style="background-color: white;">Email</b></label>
		<input type="email" placeholder="Enter your email" name="email" required>

		<label for="psw"><b style="background-color: white;" >Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" 
                pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters"
                required>
		<!-- <input type="password" placeholder="Enter Password" name="password" required> -->
		<button type="submit">Register</button>
		<!-- <label>
		<input type="checkbox" checked="checked" name="remember"> Remember me
		</label> -->
	</div>

	<div class="container" style="background-color:#f1f1f1">
		<button type="button" class="cancelbtn">Cancel</button>
	</div>
</form>

</body>
</html>
<!-- <div class="row">
	<div class="col-12">
		<div class="mb-4">
			<h3>Sign up</h3>
			<p>Already has an account? <a href="index.php?page=login">Sign in</a></p>
		</div>
	</div>
</div>
<form method="POST" action="index.php?page=register/register" class="needs-validation" novalidate autocomplete="off">
<div class="row gy-3 overflow-hidden">
	<div class="col-12">
		<div class="form-floating mb-2">
			<input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
			<label for="email" class="form-label">Email</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-floating mb-2">
			<input type="password" class="form-control" name="password" id="password" value="" placeholder="Password" required>
			<label for="password" class="form-label">Password</label>
		</div>
	</div>
	<div class="col-12">
		<div class="form-floating mb-2">
			<input type="text" class="form-control" name="name" id="name" value="" placeholder="Your full name" required>
			<label for="name" class="form-label">Full name</label>
		</div>
	</div>
	<div class="row g-6">
		<div class="col-md-4">
			<label for="province" class="form-label">Province</label>
			<select class="form-select" id="province" name="province" required onchange="fetchDistricts()">
				<option disabled selected value>Select province</option>

				<?php foreach ($data['provinces'] as $province) :
					echo '<option value ="'. $province['code'] . '">' . $province['name_en'] . '</option>';
				endforeach; ?>
			</select>
		</div>
		<div class="col-md-4">
			<label for="district" class="form-label">District</label>
			<select class="form-select" id="district" name="district" required onchange="fetchWards()">
			</select>
		</div>
		<div class="col-md-4">
			<label for="ward" class="form-label">Ward</label>
			<select class="form-select" id="ward" name="ward" required>
			</select>
		</div>
	</div>
	<div class="col-12">
		<div class="d-grid">
			<button class="btn btn-primary btn-lg" type="submit" name="submit">Register now</button>
		</div>
	</div>

</div>
</form>

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

    function fetchDistricts() {
        $.ajax({
            type: "POST",
            url: "index.php?page=register/fetchDistricts",
            data: { province: $("#province").val() },
            dataType: "json",
            success: function (data) {
                $("#district").empty(); 
				$('#district').html(data);
            },
			error: function (xhr, status, error) {
				console.error("Error fetching districts:", status, error);
			}
        });
    }

    function fetchWards() {
        $.ajax({
            type: "POST",
            url: "index.php?page=register/fetchWards",
            data: { district: $("#district").val() },
            dataType: "json",
            success: function (data) {
                $("#ward").empty(); 
				$('#ward').html(data);
            },
			error: function (xhr, status, error) {
				console.error("Error fetching wards:", status, error);
			}
        });
    }
</script> -->