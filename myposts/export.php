<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');

function getLine($post)
{
    return "{$post['id']},{$post['title']},{$post['content']},{$post['image']},{$post['publish_date']},{$post['category_id']},{$post['user_id']}" . PHP_EOL;
}

$posts = getPosts(10);
$filename = strtotime("now") . ".csv";
$file_path = BASE_PATH . "/files/" . $filename;
$myfile = fopen($file_path, "w+") or die("Unable to open file!");
foreach ($posts as $post) {
    fwrite($myfile, getLine($post));
}
fclose($myfile);

header('Content-type: application/octet-stream');
header("Content-Type: " . mime_content_type($file_path));
header("Content-Disposition: attachment; filename=" . $filename);
while (ob_get_level()) {
    ob_end_clean();
}
readfile($file_path);
