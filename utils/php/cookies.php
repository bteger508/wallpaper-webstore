<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../../');
}

// These wrapper functions only work in certain instances, which I do not understand yet...
// If they do not work, just copy their function body.

$cookiePrefix = 'wallpaperWebstoreCS420_';

$userDataCookieName = $cookiePrefix . 'userData';
$favoriteTagCookieName = $cookiePrefix . 'favoriteTag';

DEFINE('USER_DATA_COOKIE_NAME', $userDataCookieName);
DEFINE('FAVORITE_TAG_COOKIE_NAME', $favoriteTagCookieName);

$cookieExpires = time() + (60 * 60 * 24 * 365); // 1 year
$cookiePath = '/';

function getFavoriteTag()
{
    // get Favorite Tag from cookie if it exists
    if (isset($_COOKIE[FAVORITE_TAG_COOKIE_NAME])) {
        return $_COOKIE[FAVORITE_TAG_COOKIE_NAME];
    } else {
        return null;
    }
}

function setFavoriteTag($tag)
{
    setcookie(FAVORITE_TAG_COOKIE_NAME, $tag, $GLOBALS['cookieExpires'], $GLOBALS['cookiePath']);
}

function setUserData($userDataJson)
{
    setCookie(USER_DATA_COOKIE_NAME, $userDataJson, $GLOBALS['cookieExpires'], $GLOBALS['cookiePath']);
}

function getUserCookieData()
{
    // get User Data from cookie if it exists
    if (isset($_COOKIE[USER_DATA_COOKIE_NAME])) {
        $userDataJson = $_COOKIE[USER_DATA_COOKIE_NAME];
        $userData = json_decode($userDataJson, true);
        return $userData;
    } else {
        return null;
    }
}

function clearUserCookieData()
{
    setcookie(USER_DATA_COOKIE_NAME, '', time() - 3600, $GLOBALS['cookiePath']);
}

function userIsAdmin()
{
    if (isset($_COOKIE['userData']) && !is_null($_COOKIE['userData'])) {
        $userData = json_decode($_COOKIE['userData']);
        return $userData->is_admin;
    }
    return false;
}
