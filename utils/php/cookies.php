<?php
if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../../');
}

// These wrapper functions only work in certain instances, which I do not understand yet...
// If they do not work, just copy their function body.

function getFavoriteTag()
{
    return $_COOKIE['fav-tag'];
}

function setFavoriteTag($tag)
{
    setcookie('fav-tag', $tag, 0, "/");
}

function setUserData($userDataJson)
{
    setcookie('userData', $userDataJson, 0, "/");
}
