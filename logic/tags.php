<?php
require_once(BASE_PATH . '/dal/basic_dal.php');
function getTags()
{
    $sql = "SELECT * FROM tags";
    return getRows($sql);
}