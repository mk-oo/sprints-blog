<?php
require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');

function getPostRequest($line)
{
    $vals  = explode(',', $line);
    return [
        'title' => $vals[1],
        'content' => $vals[2],
        'publish_date' => $vals[4],
        'category_id' => $vals[5]
    ];
}
function getImage($line)
{
    $vals = explode(',', $line);
    return $vals[3];
}
function getUserIdFromLine($line)
{
    $vals = explode(',', $line);
    return $vals[6];
}

$file_path = $_FILES['csv']['tmp_name'];
$myfile = fopen($file_path, "r") or die("Unable to open file!");
$content = fread($myfile, filesize($file_path));
fclose($myfile);

$lines = explode(PHP_EOL, $content);
foreach ($lines as $line) {
    if ($line == '')
        continue;
    $request = getPostRequest($line);
    $image = getImage($line);
    $user_id = getUserIdFromLine($line);
    addNewPost($request, $user_id, $image);
}

header('Location:index.php');
die();
