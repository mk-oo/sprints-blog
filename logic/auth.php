<?php
require_once(BASE_PATH . '/dal/basic_dal.php');
require_once(BASE_PATH . '/logic/auth.php');
function tryLogin($username, $password)
{
    $user = getUser($username, $password);
    if ($user != null) {
        addUserToSession($user);
    }
    return ($user != null);
}

function getUser($username, $password)
{
    $sql = "SELECT * FROM users WHERE username=? and password = md5(?) and active = '1' limit 1 ";
    return getRow($sql,'ss',[$username,$password]);
}

function addUserToSession($user)
{
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    $_SESSION['user'] = $user;
}
function logOut()
{
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    session_destroy();
    header('Location:' . BASE_URL . '/index.php');
    die();
}
function getUserId()
{
    if (session_status() != PHP_SESSION_ACTIVE) session_start();
    if (isset($_SESSION['user'])) return $_SESSION['user']['id'];
    return 0;
}