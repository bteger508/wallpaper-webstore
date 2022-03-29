<?php

if (!defined('ROOT_DIR')) {
    DEFINE('ROOT_DIR', __DIR__ . '/../../');
}

function getFavoriteTag()
{
    return $_COOKIE['fav-tag'];
}

function setFavoriteTag($tag)
{
    setcookie('fav-tag', $tag);
}

function setUserId($userId)
{
    setcookie('user_id', $userId);
}