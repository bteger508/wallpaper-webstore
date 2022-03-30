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

// Take a GET request and set productsArray to the products
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // If tag is set, get products by tag
    if (isset($_GET['tag'])) {
        $productsArray = get_by_tagname($_GET['tag'], 100);
    } else {
        // Else get all products
        $productsArray = get_all_products();
    }
}

// Retrieve all tags
$tags = retrieve_all_tags();

// Get tag name from get request if set
if (isset($_GET['tag'])) {
    $tag_in = $_GET['tag'];
} else {
    $tag_in = null;
}

?>
<!doctype html>
<html lang="en">

<head>
    <title>Landing</title>
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
    <div class="container-fluid">
        <h1>Browse Products</h1>

        <!-- This fancy PHP printing is from this article:
        https://phpdelusions.net/mysqli_examples/prepared_select -->
        <?php if ($productsArray) : ?>
            <div class="d-flex flex-row">
                <!-- Display all images -->
                <div class="col-md-9">
                <div class="d-flex flex-row flex-wrap">
                    <?php foreach ($productsArray as $product) : ?>
                    <div class="w-full mb-2">
                    <div class="card" style="width: 18rem;">
                        <img defer class="card-img-top" <?php echo 'src="../resources/upload/' . $product['path'] . '"' ?> alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">$<?php echo $product['price'] ?></h5>
                            <p class="card-text"><?php echo $product['description'] ?></p>
                            <a href="#" class="btn btn-primary">Add to Cart</a>
                        </div>
                    </div>
                    </div>
                    <?php endforeach ?>
                </div>
                </div>
                <!-- Show all possible tags to browse by -->
                <div class="col-md-2">
                    <div class="list-group">
                        <a href="index.php" class="list-group-item list-group-item-action">All</a>
                        <?php foreach ($tags as $tag) : ?>
                            <a href="index.php?tag=<?php echo $tag['name']; ?>" class="list-group-item list-group-item-action"><?php echo $tag['name']; ?></a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif ?>


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