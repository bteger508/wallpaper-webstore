<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}

include_once(ROOT_DIR . './utils/php/cookies.php');
include_once(ROOT_DIR . './utils/php/dao.php');
include_once(ROOT_DIR . './utils/php/product-dao.php');

// If the user is logged in, get the user's id
if (isset(getUserCookieData()['user_id'])) {
    $user_id = getUserCookieData()['user_id'];
} else {
    $user_id = null;
}

// Take a GET request and set product array to the product
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If product_id is set, set it
    if (isset($_GET['product_id'])) {
        $product_id = strval($_GET['product_id']);
    } else {
        $product_id = null;
    }
}

// Get the product if it exists
if (isset($product_id)) {
    $product = get_product_by_id($product_id);
} else {
    $product = null;
}

?>

<?php 
// redirect if the product is not found
if (!isset($product)) {
    header('Location: ../browse-page' );
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Browse Product</title>
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
    <div class="container-fluid m-1">
        <h1><?php echo $product['title'] ?></h1>
        <div class="row">
            <div class="col-md-6">
                <img defer <?php echo 'src=../resources/upload/' . $product['path'] ?> class="img-fluid img-thumbnail" alt="<?php echo $product['altText'] ?>">
            </div>
            <div class="col-md-6">
                <!-- if user is logged in, show add to cart button -->
                <?php if (isset($user_id)) { ?>
                    <a href="../browse-page/add-to-cart.php?product_id=<?php echo $product['product_id']?>" class="btn btn-primary">Add to Cart</a>
                <?php } ?>

                <h3>Description</h3>
                <p><?php echo $product['description'] ?></p>
                <h3>Price</h3>
                <p>$<?php echo $product['price'] ?></p>
                <h3>Tags</h3>
                <p><?php 
                    // Get the tags for the product
                    $tags = get_tags_by_product_id($product_id);
                    // Loop through the tags and print them
                    foreach ($tags as $tag) {
                        echo $tag['name'] . ' ';
                    }
                ?></p>
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