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
    } else if (isset($user_id) && isset($_GET['likes']) && $_GET['likes'] == 'true') {
        // If likes is set, get products by likes
        $productsArray = get_products_by_user_likes($user_id);
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
    incrementTagScore($tag_in, 1);
} else {
    $tag_in = null;
}

// Get the user's liked products
if (isset($user_id)) {
    $liked_products = get_liked_products_by_user_id($user_id);
} else {
    $liked_products = null;
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="index.css" />
</head>
<script src="./index.js" defer></script>

<body>
    <?php
    include_once(ROOT_DIR . './shared/nav-toolbar.php')
    ?>
    <div class="container-fluid pb-5">
        <h1>Browse Products</h1>

        <!-- This fancy PHP printing is from this article:
        https://phpdelusions.net/mysqli_examples/prepared_select -->
        <div class="d-flex flex-row w-100">
        <?php if ($productsArray) : ?>
                <!-- Display all images -->
                <div class="d-flex flex-row flex-wrap mr-auto">
                    <?php foreach ($productsArray as $product) : ?>
                    <div class="w-full m-2">
                    <div class="card grow-hover" style="width: 18rem;">
                    <a href="<?php echo '../browse-product/index.php?product_id=' . $product['product_id'] ?>">
                        <img defer class="card-img-top img-thumbnail" <?php echo 'src="../resources/upload/' . $product['path'] . '"' ?> alt="Card image cap">
                    </a>
                        <div class="card-body">
                            <h5 class="card-title">$<?php echo $product['price'] ?></h5>
                            <p class="card-text"><?php echo $product['description'] ?></p>
                            <?php if ($user_id) : ?>
                                <!-- Add to cart button -->
                                <a href="./add-to-cart.php?product_id=<?php echo $product['product_id'] ?>" class="btn btn-primary">Add to Cart</a>
                                <!-- Like Button -->
                                <script>
                                    function likeProduct(product_id) {
                                        var xhttp = new XMLHttpRequest();
                                        xhttp.onreadystatechange = function() {
                                            if (this.readyState == 4 && this.status == 200) {
                                                let icon = document.getElementById("like-icon-" + product_id)
                                                if (icon.style.color == "deeppink") {
                                                    icon.style.color = "black"
                                                    // remove class name
                                                    icon.classList.remove("fas")
                                                    icon.classList.add("far")
                                                } else {
                                                    icon.style.color = "deeppink"
                                                    // remove class name
                                                    icon.classList.remove("far")
                                                    icon.classList.add("fas")
                                                }
                                            }
                                        };
                                        if (document.getElementById("like-icon-" + product_id).style.color == "deeppink") {
                                            xhttp.open("GET", "./unlike-product.php?product_id=" + product_id, true);
                                        } else {
                                            xhttp.open("GET", "./like-product.php?product_id=" + product_id, true);
                                        }
                                        xhttp.send();
                                    }
                                </script>
                                <?php if (is_product_liked($liked_products, $product['product_id'])) : ?>
                                    <i 
                                    id="<?php echo 'like-icon-'.$product['product_id']?>" 
                                    class="fas fa-heart pl-2 mouse-pointer" 
                                    style="color:deeppink"
                                    onclick="likeProduct(<?php echo $product['product_id'] ?>)"></i>
                                <?php else : ?>
                                    <i 
                                    id="<?php echo 'like-icon-'.$product['product_id']?>" 
                                    class="far fa-heart pl-2 mouse-pointer"
                                    onclick="likeProduct(<?php echo $product['product_id'] ?>)"></i>
                                <?php endif ?>
                                <!-- <i class="fas fa-heart" style="color:deeppink"></i> -->
                            <?php endif; ?>
                        </div>
                    </div>
                    </div>
                    <?php endforeach ?>
                </div>
            <?php endif ?>
            <!-- Show all possible tags to browse by -->
            <div class="col-sm-1 m-0 p-0 align-self-end ml-auto">
                <div class="list-group">
                    <!-- All -->
                    <a href="index.php" 
                        class="list-group-item list-group-item-action
                        <?php if ($tag_in == null && !isset($_GET['likes'])) {echo 'active-tag';} ?>
                        ">
                        All</a>
                    <!-- Likes -->
                    <a href="./index.php?likes=true" class="list-group-item list-group-item-action <?php if ($tag_in == null && isset($_GET['likes'])) {echo 'active-tag';} ?>">Likes <i class="fas fa-heart"></i></a>
                    <!-- Tags -->
                    <?php foreach ($tags as $tag) : ?>
                        <a href="index.php?tag=<?php echo $tag['name']; ?>" class="list-group-item list-group-item-action 
                        <?php 
                            if ($tag['name'] == $tag_in) {echo 'active-tag';} 
                        ?>"
                        >
                        <?php echo $tag['name']; ?></a>
                    <?php endforeach; ?>
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