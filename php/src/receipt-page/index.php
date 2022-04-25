<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include_once(ROOT_DIR . './utils/php/cookies.php');
include_once(ROOT_DIR . './utils/php/product-dao.php');


// If the user is logged in, get the user's id
if (isset(getUserCookieData()['user_id'])) {
    $user_id = getUserCookieData()['user_id'];
} else {
    $user_id = null;
}

// Get the products in the user's cart 
if (isset($user_id)) {
    $products = get_products_in_cart_for_user($user_id);
} else {
    $products = null;
}

// clear the products in the cart
remove_all_products_from_cart($user_id);

// format a decimal to dollars and cents
function format_decimal_to_dollars_and_cents($decimal) {
	return number_format($decimal, 2);
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Receipt Page</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" href="index.css" />
</head>
<script src="./index.js" defer></script>

<body>
    <?php
    include_once(ROOT_DIR . './shared/nav-toolbar.php')
    ?>
    <div class="container-fluid px-2">
        <h1>Congrats on your Checkout!</h1>
        <h2>Your total is: $<span>
                <?php
                if (isset($products)) {
                    $total = 0;
                    foreach ($products as $product) {
                        $total += $product['price'];
                    }
                    echo format_decimal_to_dollars_and_cents($total);
                }
                ?>
            </span></h2>
        </span></h2>
        <?php if ($products) { ?>
            <?php foreach ($products as $product) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="col-3">
                                <img defer class="card-img-top img-thumbnail" height="100px" <?php echo 'src="../resources/upload/' . $product['path'] . '"' ?> alt="Card image cap">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $product['title'] ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo $product['description'] ?>
                                </p>
                                <a target="_blank" href="../receipt-page/download-image.php?path=<?php echo $product['path'] ?>" class="btn btn-primary">Download</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                There were no products in your cart.
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="row">
            <div class="col-12">
                <a href="../landing-page/index.php" class="btn btn-primary m-2">Return to Home Page</a>
            </div>
        </div>

    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>