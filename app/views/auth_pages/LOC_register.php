<div class="row">
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
</script>