<?php
require_once(BASE_PATH . '/dal/basic_dal.php');
function getCategories()
{
    $sql = "SELECT * FROM categories";
    return getRows($sql);
}