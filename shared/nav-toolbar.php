<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
// include ROOT_DIR . './utils/php/dao.php';

// checks if wallpaperWebstoreCS420_userData cookie exists
if (isset($_COOKIE['wallpaperWebstoreCS420_userData'])) {
    $userData = json_decode($_COOKIE['wallpaperWebstoreCS420_userData'], true);
    $username = $userData['username'];
    $first_name = $userData['first_name'];
    $last_name = $userData['last_name'];
    $email = $userData['email'];
    $phone = $userData['phone_number'];
    $dob = $userData['date_of_birth'];
    $favColor = $userData['favorite_color'];
    $isAdmin = $userData['is_admin'];
} else {
    $username = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $phone = '';
    $dob = '';
    $favColor = '';
    $isAdmin = false;
}
?>

<nav class="container-fluid">
    <div class="row justify-content-between">
        <div class="col">
            <span class="h2 p-2">
                <?php if ($username) { ?>
                    Welcome back, <?php echo $first_name; ?>
                <?php } else { ?>
                    Wallpaper Webstore
                <?php } ?>
            </span>
        </div>
        <div class="col col-auto">
            <div class="row">
                <?php if ($isAdmin) { ?>
                    <a id="admin_route" class="nav-link" href="../view-users-page">Admin</a>
                    <a id="insert_route" class="nav-link" href="../insert-product-page/index.php">Insert</a>
                <?php } ?>
                <a id="home_route" class="nav-link" href="../landing-page">Home</a>
                <?php if(!$username) { ?>
                    <a id="login_route" class="nav-link" href="../login-page">Login</a>
                    <a id="register_route" class="nav-link" href="../register-page">Register</a>
                <?php } else { ?>
                    <a id="cart_route" class="nav-link" href="../cart-page">Cart</a>
                    <a id="logout_route" class="nav-link" href="../logout-page">Logout</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>