
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
                <!-- <span id="likes_count_<?= $post['id'] ?>"><?= $post['likes_count']; ?></span> Likes -->
            </div>
            <div class="col-md-6">

                <br>
                <br>
                <button id="likes_btn_<?= $post['id'] ?>" class="btn" type="button" onclick="likePost(<?= $post['id']; ?>)" style="display:<?= !$post['liked_by_me'] ? "block" : "none" ?>">Like Post</button>
                <button id="unlikes_btn_<?= $post['id'] ?>" class="btn" type="button" onclick="unLikePost(<?= $post['id']; ?>)" style="display:<?= !$post['liked_by_me'] ? "none" : "block" ?>">UnLike Post</button>
            </div>
        </div>
        <br>
        <form name="form" action="" method="post">
            <input type="text" name="subject" id="data" >
            <button class="btn btn-success">add</button>
        </form>
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