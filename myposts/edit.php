<?php

require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/tags.php');
require_once(BASE_PATH . '/logic/categories.php');
$tags = getTags();
$categories = getCategories();
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

if (isset($_REQUEST['title'])) {
    $errors = validatePostEdit($_REQUEST);
    if (count($errors) == 0) {
        if (editPost($id,$_REQUEST, getUploadedImage($_FILES))) {
            header('Location:index.php');
            die();
        } else {
            $generic_error = "Error while edit the post";
        }
    }
}

function postHasTag($id, $tags)
{
    foreach ($tags as $tag) {
        if ($tag['tag_id'] == $id)
            return true;
    }
    return false;
}
var_export($_REQUEST);
require_once(BASE_PATH . '/layout/header.php');
?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
    <section class="page-heading">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-content">
                        <h4>Edit Post</h4>
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
                <div class="all-blog-posts">
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="POST" enctype="multipart/form-data">
                                <input name="title" placeholder="title" class="form-control" value="<?= $post['title'] ?>" />
                                <?= isset($errors['title']) ? "<span class='text-danger'>" . $errors['title'] . "</span>" : "" ?>
                                <textarea name="content" placeholder="content" class="form-control"><?= $post['content'] ?></textarea>
                                <?= isset($errors['content']) ? "<span class='text-danger'>" . $errors['content'] . "</span>" : "" ?>
                                <label>Upload Image<input type="file" name="image" /></label><br />
                                <img width="500" height="500" src="<?= BASE_URL . '/post_images/' . $post['image'] ?>" />
                                <?= isset($errors['image']) ? "<span class='text-danger'>" . $errors['image'] . "</span>" : "" ?>
                                <label>Publish date<input type="date" name="publish_date" class="form-control" value="<?= date('Y-m-d',strtotime($post['publish_date'])) ?>"></label>
                                <?= isset($errors['publish_date']) ? "<span class='text-danger'>" . $errors['publish_date'] . "</span>" : "" ?>
                                <select name="category_id" class="form-control">
                                    <option value="">Select category</option>
                                    <?php
                                    foreach ($categories as $category) {
                                        echo "<option " . ($category['id'] == $post['category_id'] ? "selected" : "") . " value='{$category['id']}'>{$category['name']}</option>";
                                    }
                                    ?>
                                </select>
                                <?= isset($errors['category_id']) ? "<span class='text-danger'>" . $errors['category_id'] . "</span>" : "" ?>
                                <select name="tags[]" multiple class="form-control">
                                    <?php
                                    foreach ($tags as $tag) {
                                        echo "<option " . (postHasTag($tag['id'], $post['tags']) ? "selected" : "") . " value='{$tag['id']}'>{$tag['name']}</option>";
                                    }
                                    ?>
                                </select>
                                <?= isset($errors['tags']) ? "<span class='text-danger'>" . $errors['tags'] . "</span>" : "" ?>
                                <button class="btn btn-success">Edit Post</button>
                                <a href="index.php" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once(BASE_PATH . '/layout/footer.php') ?>