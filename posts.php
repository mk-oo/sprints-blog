<?php
require_once('config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/categories.php');
$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : null;
$tag_id = isset($_REQUEST['tag_id']) ? $_REQUEST['tag_id'] : null;
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : null;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$page_size = 6;
$posts = getPosts($page_size, $page, $category_id, $tag_id, null,null, $q, 'publish_date', 'desc', getUserId());
$posts_count  = getPostsCount($category_id, $tag_id, null,null, $q);
$page_count = ceil($posts_count / $page_size);
function getUrl($p, $category_id, $tag_id, $q)
{
    $url = BASE_URL . "/posts.php?page=$p";
    if ($category_id != null) $url .= "&category_id=$category_id";
    if ($tag_id != null) $url .= "&tag_id=$tag_id";
    if ($q != null) $url .= "&q=$q";
    return $url;
}
?>
<?php
//  $ci = getPostCommentsCount($post['id']);
//  var_dump($ci);

?>
<?php require_once('layout/header.php'); ?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Recent Posts</h4>
                        <h2>Our Recent Blog Entries</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Banner Ends Here -->
<section class="blog-posts">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="sidebar-item search">
                    <form id="search_form" name="gs" method="GET" action="<?= BASE_URL . '/posts.php' ?>">
                        <input type="text" value="<?= isset($_REQUEST['q']) ? $_REQUEST['q'] : '' ?>" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="all-blog-posts">
                    <div class="row">
                        <?php
                        foreach ($posts as $post) {
                        ?>

                            <div class="blog-post">
                                <div class="blog-thumb">
                                    <img src="<?= BASE_URL . '/post_images/' . $post['image'] ?>" alt="">
                                </div>
                                <div class="down-content">
                                    <span><?= $post['category_name'] ?></span>
                                    <a href="<?= BASE_URL . '/post-details.php?id=' . $post['id'] ?>">
                                        <h4><?= $post['title'] ?></h4>

                                    </a>
                                    <p><?= $post['content'] ?></p>
                                    <?php
                                    if ($post['tags']) {
                                    ?>
                                        <div class="post-options">
                                            <div class="row">
                                                <div class="col-6">
                                                    <ul class="post-tags">
                                                        <li><i class="fa fa-tags"></i></li>
                                                        <?php
                                                        foreach ($post['tags'] as $tag) {
                                                        ?>
                                                            <li><a href="<?= BASE_URL . "/posts.php?tag_id={$tag['id']}" ?>"><?= $tag['name'] ?></a></li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <span id="likes_count_<?= $post['id'] ?>"><?= $post['likes_count']; ?></span> Likes
                                        </div>
                                        <div class="col-md-6">

                                            <br>
                                            <br>

                                            <button id="likes_btn_<?= $post['id'] ?>" class="btn" type="button" onclick="likePost(<?= $post['id']; ?>)" style="display:<?= !$post['liked_by_me'] ? "block" : "none" ?>">Like Post</button>
                                            <button id="unlikes_btn_<?= $post['id'] ?>" class="btn" type="button" onclick="unLikePost(<?= $post['id']; ?>)" style="display:<?= !$post['liked_by_me'] ? "none" : "block" ?>">UnLike Post</button>
                                        </div>
                                    </div>
                                    <br>
                                    <form name="form" action="" method="POST">
                                        <input type="text" name="seb" id="data">
                                        <button class="btn btn-success">add</button>
                                    </form>
                                    <?php
                                    if (isset($_POST['seb'])) {
                                        addComment($_POST['seb'], '2021-09-25 17:42:59', $post['id'], $post['user_id']);
                                    }
                                    ?>

                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>id</th>
                                                <th>Comment</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ci = getPostCommentsCount($post['id']);

                                            for ($i = 0; $i < count($ci); $i++) {

                                                echo "<tr>
                                                <td>$i</td>
                                                <td>{$ci[$i]['id']}</td>
                                                <td>{$ci[$i]['comment']}</td>
                                                <td>
                                                <a onclick='return confirm(\"Are you sure ?\")' href='deleteComment.php?id={$ci[$i]['id']}' class='btn btn-danger'>Delete</a>
                                                </td>
                                                </tr>";
                                            }

                                            ?>
                                        </tbody>
                                    </table>


                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <ul class="page-numbers">
                        <?php
                        $prevUrl = getUrl($page - 1, $category_id, $tag_id, $q);
                        $nxtUrl = getUrl($page + 1, $category_id, $tag_id, $q);

                        if ($page > 1) echo "<li><a href='{$prevUrl}'><i class='fa fa-angle-double-left'></i></a></li>";

                        for ($i = 1; $i <= $page_count; $i++) {
                            $url = getUrl($i, $category_id, $tag_id, $q);
                            echo "<li class=" . ($i == $page ? "active" : "") . "><a href='{$url}'>{$i}</a></li>";
                        }

                        if ($page < $page_count) echo "<li><a href='{$nxtUrl}'><i class='fa fa-angle-double-right'></i></a></li>";
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once('layout/footer.php') ?>