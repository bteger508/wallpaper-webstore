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
		<!-- ===== Include Navbar ===== -->
		<?php
		include_once(ROOT_DIR.'./shared/nav-toolbar.php');
		?>

		<!-- ===== Show All Users -->
		<?php
		include_once(ROOT_DIR.'./utils/php/dao.php');
		echo "<table>";
		echo "<tr>";
		echo "<td><strong>Username</strong></td>";
		echo "<td><strong>Email</strong></td>";
		echo "<td><strong>First Name</strong></td>";
		echo "<td><strong>Last Name</strong></td>";
		echo "<td><strong>Date of Birth</strong></td>";
		echo "<td><strong>Phone Number</strong></td>";
		echo "<td><strong>Account Created On</strong></td>";
		echo "</tr>";
		foreach (retrieve_all_users() as $user) {
			echo "<tr>";
			echo "<td>" . $user['username'] . "</td>";
			echo "<td>" . $user['email'] . "</td>";
			echo "<td>" . $user['first_name'] . "</td>";
			echo "<td>" . $user['last_name'] . "</td>";
			echo "<td>" . $user['date_of_birth'] . "</td>";
			echo "<td>" . $user['phone_number'] . "</td>";
			echo "<td>" . $user['create_time'] . "</td>";
			echo "</tr>";
		}
		echo "</table>";
		?>


        <!-- ============= END OF PAGE CONTENT ================= -->

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
