<?php

require_once('../config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/tags.php');
require_once(BASE_PATH . '/logic/categories.php');

if (!isset($_REQUEST['id'])) {
    header('Location:index.php');
    die();
}
// $id = $_REQUEST['id'];
// $post = getPostById($id);
// if (!checkIfUserCanEditPost($post)) {
//     header('Location:index.php');
//     die();
// }


// $errors = validatePostEdit($_REQUEST);

;
if (isset($_REQUEST['name'])) {
    $errors = validatePostEdit($_REQUEST);
    if (count($errors) == 0) {
        if (editUser($_REQUEST['id'], $_REQUEST )) {
            header('Location:index.php');
            die();
        } else {
            $generic_error = "Error while edit the user";
        }
    }
}

//var_export();
$users = getUsersById($_REQUEST['id']);
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
                        <h4>Edit User</h4>
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
                                <input name="name" placeholder="name" class="form-control" value="<?= $users['name'] ?>" />

                                <input name="username" placeholder="username" class="form-control" value="<?= $users['username'] ?>" />
                                <input name="email" placeholder="email" class="form-control" value="<?= $users['email'] ?>" />
                                <input name="phone" placeholder="phone" class="form-control" value="<?= $users['phone'] ?>" />

                                <button class="btn btn-success">Edit user</button>
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