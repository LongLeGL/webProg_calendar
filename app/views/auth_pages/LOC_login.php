<div class="row">
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
</script>