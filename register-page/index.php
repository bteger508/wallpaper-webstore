<?php
if (!defined('ROOT_DIR')) {
	DEFINE('ROOT_DIR', __DIR__.'/../');
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Title</title>
		<!-- Required meta tags -->
		<meta charset="utf-8" />
		<meta
			name="viewport"
			content="width=device-width, initial-scale=1, shrink-to-fit=no"
		/>

		<!-- Bootstrap CSS -->
		<link
			rel="stylesheet"
			href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
			integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
			crossorigin="anonymous"
		/>

		<link rel="stylesheet" href="index.css" />
	</head>
	<script src="index.js" defer></script>
	<body>
		<?php
		include_once(ROOT_DIR.'./shared/nav-toolbar.php')
		?>

		<!-- BootStrap form -->
		<div class="login-form container-fluid">
			<span class="h1">Register</span>

			<form
				method="post"
				action="register_validation.php"
				class="col"
				id="registerForm"
			>
				<!-- Username -->
				<div class="form-group row">
					<label for="username" class="col-2 col-form-label mr-2 text-right"
						>Username</label
					>
					<div class="col-xs-9">
						<input
							type="text"
							class="form-control"
							name="username"
							id="username"
							placeholder=""
							required
						/>
					</div>
				</div>

				<!-- First Name -->
				<div class="form-group row">
					<label for="fname" class="col-2 col-form-label mr-2 text-right"
						>First Name</label
					>
					<div class="col-xs-9">
						<input
							type="text"
							name="fname"
							id="fname"
							class="form-control"
							placeholder=""
							aria-describedby="helpId"
							required
						/>
					</div>
				</div>

				<!-- Last Name -->
				<div class="form-group row">
					<label for="lname" class="col-2 col-form-label mr-2 text-right"
						>Last name</label
					>
					<div class="col-xs-9">
						<input
							type="text"
							class="form-control"
							name="lname"
							id="lname"
							placeholder=""
							required
						/>
					</div>
				</div>

				<!-- Email -->
				<div class="form-group row">
					<label for="email" class="col-2 col-form-label mr-2 text-right"
						>Email</label
					>
					<div class="col-xs-9">
						<input
							type="email"
							class="form-control"
							name="email"
							id="email"
							placeholder=""
							required
						/>
					</div>
				</div>

				<!-- Password -->
				<div class="form-group row">
					<label for="password" class="col-2 col-form-label mr-2 text-right"
						>Password</label
					>
					<div class="col-xs-9">
						<input
							type="password"
							class="form-control"
							name="password"
							id="password"
							placeholder=""
							required
						/>
					</div>
				</div>

				<!-- Password Confirm -->
				<div class="form-group row">
					<label for="pwConfirm" class="col-2 col-form-label mr-2 text-right"
						>Confirm Password</label
					>
					<div class="col-xs-9">
						<input
							type="password"
							class="form-control"
							name="pwConfirm"
							id="pwConfirm"
							placeholder=""
							required
						/>
					</div>
				</div>

				<!-- Phone -->
				<div class="form-group row">
					<label for="phone" class="col-2 col-form-label mr-2 text-right"
						>Phone</label
					>
					<div class="col-xs-9">
						<input
							type="tel"
							class="form-control"
							name="phone"
							id="phone"
							placeholder=""
							pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"
							required
						/>
					</div>
				</div>

				<!-- Date of Birth -->
				<div class="form-group row">
					<label for="dob" class="col-2 col-form-label mr-2 text-right"
						>Date of Birth</label
					>
					<div class="col-xs-9">
						<input
							type="date"
							class="form-control"
							name="dob"
							id="dob"
							placeholder=""
							required
						/>
					</div>
				</div>

				<!-- Color -->
				<div class="form-group row">
					<label for="favColor" class="col-2 col-form-label mr-2 text-right"
						>Favorite Color</label
					>
					<div class="col-xs-9">
						<input
							type="color"
							class="col-form-control form-control-color"
							name="favColor"
							id="favColor"
							value="#563d7c"
							required
						/>
					</div>
				</div>

				<!-- Terms of Service -->
				<div class="form-group row">
					<label for="serviceAgreement" class="col-3 col-form-label mr-2"
						>I have read and agree to the terms of service</label
					>
					<div class="col-xs-9">
						<input
							type="checkbox"
							class="col-form-check-input"
							name="serviceAgreement"
							id="serviceAgreement"
							value="true"
							required
						/>
					</div>
				</div>

				<!-- <fieldset class="form-group row">
                <legend class="col-form-legend col-sm-1-12">Register</legend>
                <div class="col-sm-1-12">
                    Register new user
                </div>
            </fieldset> -->

				<div class="col" id="registerErrors" style="color: red"></div>

				<!-- Submit Register Form Button -->
				<div class="form-group row">
					<div class="offset-sm-2 col-sm-10">
						<button
							type="input"
							class="btn btn-primary"
							id="submit"
							value="submit"
						>
							Register
						</button>
					</div>
				</div>
			</form>
		</div>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script
			src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
			integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
			crossorigin="anonymous"
		></script>
		<script
			src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
			integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
			crossorigin="anonymous"
		></script>
		<script
			src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
			integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
			crossorigin="anonymous"
		></script>
	</body>
</html>
