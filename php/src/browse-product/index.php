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
    // Get the tags for the product
    $tags = get_tags_by_product_id($product_id);
    $tagNames = array();
    foreach ($tags as $tag) {
        array_push($tagNames, $tag['name']);
    }
    incrementTagScores($tagNames, 2);
} else {
    $product = null;
    $tags = null;
}

?>

<?php 
// redirect if the product is not found
if (!isset($product)) {
    header('Location: ../browse-page' );
}
?>

<?php
function prettify_date_with_time($date) {
    $date = strtotime($date);
    return date('F j, Y, g:i a', $date);
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                    // Loop through the tags and print them
                    foreach ($tags as $tag) {
                        echo $tag['name'] . ' ';
                    }
                ?></p>
                <h3><i class="fas fa-heart" style="color:deeppink"></i> <?php echo get_total_likes_by_product_id($product_id) ?></h3>
                <h3>Comments</h3>
                <?php
                // Get the comments for the product
                $comments = get_comments_by_product_id($product_id);
                ?>
                <div class="container-fluid m-0 p-0 h-25 overflow-auto">
                    <?php foreach ($comments as $comment) { ?>
                        <div class="py-2">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-text"><?php echo $comment['text'] ?></p>
                                </div>
                                <div class="card-footer">
                                    <small class="text-muted">Posted on <?php echo prettify_date_with_time($comment['create_time']) ?></small>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- add comment section  -->
                <?php if (isset($user_id)) { ?>
                    <form action="./add-comment.php" method="POST">
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                <?php } ?>

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