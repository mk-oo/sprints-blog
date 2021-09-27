<?php

require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
if (!isset($_REQUEST['id'])) {
    header('Location:index.php');
    die();
}
$id = $_REQUEST['id'];
$post = getPostById($id);
if (!checkIfUserCanEditPost($post)) {
    header('Location:index.php');
    die();
}
deletePost($id);
header('Location:index.php');
die();
