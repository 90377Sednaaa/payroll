<?php
session_start();
?>	


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<title>Log In</title>
</head>

<body style="background: rgb(59,58,77);
background: linear-gradient(90deg, rgba(59,58,77,1) 0%, rgba(54,220,254,1) 0%, rgba(0,0,255,1) 100%);">
	<div class="container-fluid d-flex justify-content-center align-items-center vh-100 ">
		<div class="row bg-white shadow box-shadow" style="border-radius: 10px;">
			<div class="col" style="background-color: rgb(10, 147, 226); border-radius: 10px;">
				<img src="../images/log-in.svg" class="img-fluid" style="width: 800px;">
			</div>
			<div class="col mt-4">
				<h1 class="text-dark text-center mt-3">Log In</h1>
				
					<div>
						<form action="../includes/login.php" method="post" >
							<div class="mb-3">
								<label for="inputEmail" class="form-label">Email address</label>
								<input name="email" type="email" class="form-control" id="inputEmail" placeholder="Enter Email" required>
							</div>
							<div class="mb-3">
								<label for="inputPassword" class="form-label">Password</label>
								<input name="password" type="password" class="form-control" id="inputPassword" placeholder="Enter Password" required>
							</div>
							<div class="mb-3 form-check">
								<input name="showpassword" type="checkbox" class="form-check-input" id="show_password">
								<label class="form-check-label" for="show_password">Show password.</label>
							</div>
							<button type="submit" class="btn btn-primary w-100">Log In</button>
					</div>
					</form>
					<div>
						<p class="mt-3 text-center">Don't Have an account? <a href="../index.php">Sign Up.</a></p>
					</div>
					<?php if (isset($_SESSION['error'])): ?>
						<div class="alert alert-danger text-center" role="alert">
							<?php echo $_SESSION['error'];
							unset($_SESSION['error']); ?>
						</div>
					<?php endif; ?>
			</div>
		</div>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
	<script>
    document.getElementById('show_password').addEventListener('change', function() {
        var passwordField = document.getElementById('inputPassword');
        if (this.checked) {
            passwordField.type = 'text'; // Show password
        } else {
            passwordField.type = 'password'; // Hide password
        }
    });
</script>
</body>

</html>