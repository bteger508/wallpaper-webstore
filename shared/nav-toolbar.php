<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../');
}
include_once(ROOT_DIR . './utils/php/dao.php');
include_once(ROOT_DIR . './utils/php/cookies.php');

// checks if wallpaperWebstoreCS420_userData cookie exists
if (getUserCookieData() !== null) {
    $userData = getUserCookieData();
    $username = $userData['username'];
    $first_name = $userData['first_name'];
    $last_name = $userData['last_name'];
    $email = $userData['email'];
    $phone = $userData['phone_number'];
    $dob = $userData['date_of_birth'];
    $favColor = $userData['favorite_color'];
    $isAdmin = $userData['is_admin'];
    $dateSignedUp = new DateTime($userData['create_time']);
} else {
    $username = '';
    $first_name = '';
    $last_name = '';
    $email = '';
    $phone = '';
    $dob = '';
    $favColor = '';
    $isAdmin = false;
    $dateSignedUp = null;
}

// checks if date is greater than 1 day
function userAccountOlderThan1Day($dateSignedUp)
{
    $currentDate = new DateTime();
    $diff = $currentDate->diff($dateSignedUp);
    return $diff->d > 1;
}

?>

<nav class="container-fluid">
    <div class="row justify-content-between">
        <div class="col">
            <span class="h2 p-2">
                <?php if ($username && userAccountOlderThan1Day($dateSignedUp)) { ?>
                    Welcome back, <?php echo $first_name; ?>!
                <?php } elseif ($username) { ?>
                    Welcome to the Wallpaper Store, <?php echo $first_name; ?>!
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