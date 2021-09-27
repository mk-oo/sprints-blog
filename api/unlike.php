<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
$id = $_REQUEST['id'];
unlikePost($id, getUserId());
echo true;
