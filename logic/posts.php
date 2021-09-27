<?php
require_once(BASE_PATH . '/dal/basic_dal.php');

function getPosts(
    $page_size,
    $page = 1,
    $category_id = null,
    $tag_id = null,
    $user_id = null,
    $follow_id = null,
    $q = null,
    $order_field = "publish_date",
    $order_by = "desc",
    $like_by_user_id = null
) {

    $offset = ($page - 1) * $page_size;

    $sql = "SELECT p.*,c.name AS category_name,u.name AS user_name FROM posts p
    INNER JOIN categories c ON c.id=p.category_id
    INNER JOIN users u ON u.id=p.user_id
    WHERE 1=1";

    $types = '';
    $vals = [];
    $sql = addWhereConditions($sql, $category_id, $tag_id, $user_id,$follow_id, $q, $types, $vals);
    $sql .= " ORDER BY $order_field $order_by limit $offset,$page_size";

    $posts =  getRows($sql, $types, $vals);
    for ($i = 0; $i < count($posts); $i++) {
        $posts[$i]['comments'] = getPostCommentsCount($posts[$i]['id']);
        $posts[$i]['tags'] = getPostTags($posts[$i]['id']);
        $posts[$i]['likes_count'] = getLikesCount($posts[$i]['id']);
        if ($like_by_user_id) {
            $posts[$i]['liked_by_me'] = getIfLikedByMe($posts[$i]['id'], $like_by_user_id);
        } else
            $posts[$i]['liked_by_me'] = false;
    }

    return $posts;
}

function getUsers($page_size, $page = 1, $q = null, $order_field = "name", $order_by = "desc")
{

    $offset = ($page - 1) * $page_size;
    $sql = "SELECT id,name,username,email,phone FROM users ORDER BY $order_field $order_by limit $offset,$page_size ";
    $users =  getRows($sql);
    return $users;
}
function getUsersCount()
{
    $sql = "SELECT count(0)  FROM users";

    return  getRows($sql);
}
function editUser($id, $request)
{
    $vals = [$request['name'], $request['username'], $request['email'], $request['phone'], $id];
    $sql = "UPDATE users SET name=?,username=?,email=?,phone=? WHERE id=?";

    $u = editData($sql, 'sssii', $vals);

    return true;
}
function getUsersById($id)
{
    $sql = "SELECT * FROM users WHERE id=?";
    $post = getRow($sql, 'i', [$id]);
    return $post;
}

function addUser($request)
{
    $sql = "INSERT INTO users(id,name,username,password,email,phone)
    VALUES (null,?,?,?,?,?)";
    $post_id = addData($sql, 'ssssii', [
        $request['title'],
        $request['content'],
        $request['publish_date'],
        $request['category_id'],
    ]);
    if ($post_id) {
        addTags($request, $post_id);
        return true;
    }
    return false;
}

// function follower($id){
//     $sql = "SELECT p.*,c.name AS category_name,u.name AS user_name FROM posts p
//     INNER JOIN categories c ON c.id=p.category_id
//     INNER JOIN users u ON u.id=p.user_id
//     WHERE p.user_id = $id";
//     return getRows($sql, 'i', [$id]);

// }


function getIfLikedByMe($post_id, $user_id)
{
    $sql = "SELECT id FROM likes WHERE post_id=? and user_id=?";
    return getRow($sql, 'ii', [$post_id, $user_id]) != null;
}
function getPostsCount($category_id = null, $tag_id = null, $user_id = null,$follow_id=null, $q = null)
{
    $sql = "SELECT count(0) as cnt FROM posts p
    INNER JOIN categories c ON c.id=p.category_id
    INNER JOIN users u ON u.id=p.user_id
    WHERE 1=1";
    $types = '';
    $vals = [];
    $sql = addWhereConditions($sql, $category_id, $tag_id, $user_id,$follow_id, $q, $types, $vals);
    return  getRow($sql, $types, $vals)['cnt'];
}

function addWhereConditions($sql, $category_id = null, $tag_id = null, $user_id = null,$follow_id=null, $q = null, &$types, &$vals)
{
    if ($category_id != null) {
        $types .= 'i';
        array_push($vals, $category_id);
        $sql .= " AND category_id=?";
    }
    if ($user_id != null) {
        $types .= 'i';
        array_push($vals, $user_id);
        $sql .= " AND user_id=?";
    }
    if ($follow_id != null) {
        $types .= 'i';
        array_push($vals, $follow_id);
        $sql .= " AND p.user_id=?";
    }
    if ($tag_id != null) {
        $types .= 'i';
        array_push($vals, $tag_id);
        $sql .= " AND p.id IN (SELECT post_id FROM post_tags WHERE tag_id=?)";
    }
    if ($q != null) {
        $types .= 'ss';
        array_push($vals, '%' . $q . '%');
        array_push($vals, '%' . $q . '%');
        $sql .= " AND (title like ? OR content like ?)";
    }
    return $sql;
}

function getMyPosts($page_size, $page, $user_id,$follow_id, $q, $order_field, $order_by)
{
    return [
        'data' => getPosts($page_size, $page, null, null, $user_id,$follow_id, $q, $order_field, $order_by),
        'count' => getPostsCount(null, null, $user_id,$follow_id, $q)
    ];
}


function getPostCommentsCount($postId)
{
    $sql = "SELECT id,comment FROM comments WHERE post_id=$postId";
    $result = getRows($sql);
    // if ($result == null) return 0;
    return $result;
}
function getLikesCount($postId)
{
    $sql = "SELECT COUNT(0) as cnt FROM likes WHERE post_id=$postId";
    $result = getRow($sql);
    if ($result == null) return 0;
    return $result['cnt'];
}

function getPostTags($postId)
{
    $sql = "SELECT t.id,t.name FROM post_tags pt
    INNER JOIN tags t ON t.id=pt.tag_id
    WHERE post_id=$postId";
    return getRows($sql);
}

function validatePostCreate($request)
{
    $errors = [];
    return $errors;
}
function addNewPost($request, $user_id, $image)
{
    $sql = "INSERT INTO posts(id,title,content,image,publish_date,category_id,user_id)
    VALUES (null,?,?,?,?,?,?)";
    $post_id = addData($sql, 'ssssii', [
        $request['title'],
        $request['content'],
        $image,
        $request['publish_date'],
        $request['category_id'],
        $user_id
    ]);
    if ($post_id) {
        addTags($request, $post_id);
        return true;
    }
    return false;
}
function getUploadedImage($files)
{
    $strArr = explode('.', $files['image']['name']);
    $ext = $strArr[count($strArr) - 1];
    array_pop($strArr);
    $fileName = implode('.', $strArr) . '_' . strtotime("now") . '.' . $ext;
    move_uploaded_file($files['image']['tmp_name'], BASE_PATH . '/post_images/' . $fileName);
    return $fileName;
}

function getPostById($id)
{
    $sql = "SELECT * FROM posts WHERE id=?";
    $post = getRow($sql, 'i', [$id]);
    $sql = "SELECT tag_id FROM post_tags WHERE post_id=?";
    $post['tags'] = getRows($sql, 'i', [$id]);
    return $post;
}

function checkIfUserCanEditPost($post)
{
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (!isset($_SESSION['user']))
        return false;
    return $_SESSION['user']['type'] == 1 || $_SESSION['user']['id'] == $post['user_id'];
}

function validatePostEdit($request)
{
    return validatePostCreate($request);
}

function editPost($id, $request, $image)
{
    $types = 'sssi';
    $vals = [$request['title'], $request['content'], $request['publish_date'], $request['category_id']];
    $sql = "UPDATE posts SET title=?,content=?,publish_date=?,category_id=?";
    if ($image) {
        $types .= 's';
        $sql .= ",image=?";
        array_push($vals, $image);
    }
    $sql .= " WHERE id=?";
    $types .= 'i';
    array_push($vals, $id);
    if (editData($sql, $types, $vals)) {
        $sql = "DELETE FROM post_tags WHERE post_id=?";
        execute($sql, 'i', [$id]);
        addTags($request, $id);
        return true;
    }
    return false;
}

function addTags($request, $post_id)
{
    if (isset($request['tags'])) {
        foreach ($request['tags'] as $tag_id) {
            addData(
                "INSERT INTO post_tags (post_id,tag_id) VALUES (?,?)",
                'ii',
                [$post_id, $tag_id]
            );
        }
    }
}

function deletePost($id)
{
    $sql = "DELETE FROM posts WHERE id=?";
    execute($sql, 'i', [$id]);
}

function removeUser($id)
{
    $sql = "DELETE FROM users WHERE id=?";
    execute($sql, 'i', [$id]);
}

function blockUser($id)
{

    $sql = "UPDATE users SET active = '0' WHERE id = ?";

    execute($sql, 'i', [$id]);
}
function UnblockUser($id)
{

    $sql = "UPDATE users SET active = '1' WHERE id = ?";

    execute($sql, 'i', [$id]);
}
function likePost($id, $user_id)
{
    $sql = "INSERT INTO likes (id,post_id,user_id) VALUES (null,?,?)";
    execute($sql, 'ii', [$id, $user_id]);
}
function unlikePost($id, $user_id)
{
    $sql = "DELETE FROM likes WHERE post_id=? AND user_id=?";
    execute($sql, 'ii', [$id, $user_id]);
}
function addComment($comment, $date, $post_id, $user_id)
{
    
    $sql = "INSERT INTO comments (id,comment,comment_date,post_id,user_id) VALUES (null,?,?,?,?)";
    addData($sql, 'siii', [$comment, $date, $post_id, $user_id]);
}
function deleteComment($comment_id)
{
    $sql = "DELETE FROM comments WHERE id=?";
    execute($sql, 'i', [$comment_id]);
}
function makeAdmin($id)
{

    $sql = "UPDATE users SET type = '1' WHERE id=?";
    execute($sql, 'i', [$id]);
}
