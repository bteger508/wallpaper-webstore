<?php
if (!defined('ROOT_DIR')) {
	DEFINE('ROOT_DIR', __DIR__.'/../');
}

include_once ROOT_DIR.'./utils/php/cookies.php';
include_once ROOT_DIR.'./utils/php/dao.php';

// If the user is logged in, get the user's id
if (isset(getUserCookieData()['user_id'])) {
	$user_id = getUserCookieData()['user_id'];
} else {
	$user_id = null;
}

// If the userId is set, get the products in the user's cart
if (isset($user_id)) {
	$cartProducts = get_products_in_cart_for_user(getUserCookieData()['user_id']);
} else {
	$cartProducts = null;
}

// format a decimal to dollars and cents
function format_decimal_to_dollars_and_cents($decimal) {
	return number_format($decimal, 2);
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Login</title>
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
        <!-- Insert NavBar -->
		<?php
		include_once(ROOT_DIR.'./shared/nav-toolbar.php')
		?>

		<div class="container-fluid">

			<div>
				<h1>Cart</h1>
			</div>
	
			<div class="row">
				<!-- If the user is logged in, show the products in their cart. -->
				<table class="table table-striped col-md-6">
					<thead>
						<tr>
							<th scope="col">Image</th>
							<th scope="col">Product</th>
							<th scope="col">Description</th>
							<th scope="col">Price</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (isset($cartProducts)) {
							foreach ($cartProducts as $product) {
								?>
								<tr>
									<td>
									<a href="../browse-product?product_id=<?php echo $product['product_id'] ?>">
										<img class="grow-hover " height="100px" <?php echo 'src="../resources/upload/' . $product['path'] . '"' ?>>
									</a>
									</td>
									<td><?php echo $product['title']; ?></td>
									<td><?php echo $product['description']; ?></td>
									<td><?php echo $product['price']; ?></td>
								</tr>
								<?php
							}
						}?>
					</tbody>
				</table>
				<div class="col-md-2 mx-2">
					<div class="row mb-2">
						<a href="../browse-page/index.php" class="btn btn-primary">Continue Shopping</a>
					</div>
					<div class="row mb-2">
						<a href="../browse-page/index.php" class="btn btn-primary">
							Checkout 
							<!-- Items in cart -->
							(<?php
							if (isset($cartProducts)) {
								echo count($cartProducts);
							} else {
								echo '0';
							}
							?>)
							<!-- Subtotal Price -->
							<span class="badge badge-light">
								<?php
								if (isset($cartProducts)) {
									$total = 0;
									foreach ($cartProducts as $product) {
										$total += $product['price'];
									}
									echo '$' . format_decimal_to_dollars_and_cents($total);
								} else {
									echo '$0.00';
								}
								?>
							</span>
						</a>
					</div>
				</div>
			</div>

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
