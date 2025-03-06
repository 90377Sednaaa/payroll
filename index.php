<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Sign Up</title>
</head>

<body style="background: rgb(59,58,77);
background: linear-gradient(90deg, rgba(59,58,77,1) 0%, rgba(54,220,254,1) 0%, rgba(0,0,255,1) 100%);">

	<div class="container-fluid d-flex justify-content-center align-items-center vh-100 ">
		<div class="row bg-white shadow box-shadow" style="border-radius: 10px;">
			<div class="col" style="background-color: rgb(10, 147, 226); border-radius: 10px;">
				<img src="images/sign-up.svg" class="img-fluid" style="width: 800px;">
			</div>
			<div class="col">
				<h1 class="text-dark text-center mt-3">Sign Up</h1>
				<div>
					<form action="includes/signup.php" method="post">
						<div class="mb-3">
							<label for="name" class="form-label">Name</label>
							<input name="name" type="text" class="form-control" id="name" placeholder="Enter Name" required>
						</div>
						<div class="mb-3">
							<label for="email" class="form-label">Email address</label>
							<input name="email" type="email" class="form-control" id="email" placeholder="Enter Email" required>
						</div>
						<div class="mb-3">
							<label for="password" class="form-label">Password</label>
							<input name="password" type="password" class="form-control" id="password" placeholder="Enter Password" required>
						</div>
						<div class="mb-3 form-check">
							<input name="showpassword" type="checkbox" class="form-check-input" id="show_password">
							<label class="form-check-label" for="show_password">Show Password</label>
						</div>
						<button type="submit" class="btn btn-primary w-100">Sign Up</button>
				</div>
				</form>
				<div>
					<p class="mt-3 text-center">Have an account? <a href="http://localhost/payroll/login-form/login-form.php">Log in.</a></p>
				</div>
				<?php
				if (isset($_GET['error']) && $_GET['error'] === 'duplicate_email') {
					echo '<div class="alert alert-danger text-center mt-4" role="alert">Duplicate Email. Please Try Again.</div>';
				}
				?>
			</div>
		</div>
	</div>
	<script>
		document.getElementById('show_password').addEventListener('change', function() {
			var passwordField = document.getElementById('password');
			if (this.checked) {
				passwordField.type = 'text'; 
			} else {
				passwordField.type = 'password'; 
			}
		});
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>