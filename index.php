<?php
require_once('config.php');
require_once(BASE_PATH . '/logic/posts.php');
require_once(BASE_PATH . '/logic/auth.php');
require_once(BASE_PATH . '/logic/categories.php');
require_once(BASE_PATH . '/logic/tags.php');

$category_id = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : null;
$tag_id = isset($_REQUEST['tag_id']) ? $_REQUEST['tag_id'] : null;
$q = isset($_REQUEST['q']) ? $_REQUEST['q'] : null;
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
$page_size = 2;
$order_field = isset($_REQUEST['order_field']) ? $_REQUEST['order_field'] : 'id';
$order_by = isset($_REQUEST['order_by']) ? $_REQUEST['order_by'] : 'asc';
$follow =  isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
$posts = getPosts($page_size, $page, $category_id, $tag_id, null,$follow, $q, 'publish_date', 'desc', getUserId());
$posts_count  = getPostsCount($category_id, $tag_id,$follow, null, $q);
$page_count = ceil($posts_count / $page_size);
$categories = getCategories();
$tags = getTags();
$users = getUsers($page_size,$page,$q,$order_field, $order_by);


function getUrl($p, $category_id, $tag_id,$follow, $q)
{
  $url = BASE_URL . "/index.php?page=$p";
  if ($category_id != null) $url .= "&category_id=$category_id";
  if ($tag_id != null) $url .= "&tag_id=$tag_id";
  if ($follow != null) $url .= "&id=$follow";
  if ($q != null) $url .= "&q=$q";
  return $url;
}
?>
<?php require_once('layout/header.php'); ?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="main-banner header-text">
  <div class="container-fluid">
    <div class="owl-banner owl-carousel">
      <div class="item">
        <img src="assets/images/banner-item-01.jpg" alt="">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span>Fashion</span>
            </div>
            <a href="post-details.html">
              <h4>Morbi dapibus condimentum</h4>
            </a>
            <ul class="post-info">
              <li><a href="#">Admin</a></li>
              <li><a href="#">May 12, 2020</a></li>
              <li><a href="#">12 Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="assets/images/banner-item-02.jpg" alt="">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span>Nature</span>
            </div>
            <a href="post-details.html">
              <h4>Donec porttitor augue at velit</h4>
            </a>
            <ul class="post-info">
              <li><a href="#">Admin</a></li>
              <li><a href="#">May 14, 2020</a></li>
              <li><a href="#">24 Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="assets/images/banner-item-03.jpg" alt="">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span>Lifestyle</span>
            </div>
            <a href="post-details.html">
              <h4>Best HTML Templates on TemplateMo</h4>
            </a>
            <ul class="post-info">
              <li><a href="#">Admin</a></li>
              <li><a href="#">May 16, 2020</a></li>
              <li><a href="#">36 Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="assets/images/banner-item-04.jpg" alt="">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span>Fashion</span>
            </div>
            <a href="post-details.html">
              <h4>Responsive and Mobile Ready Layouts</h4>
            </a>
            <ul class="post-info">
              <li><a href="#">Admin</a></li>
              <li><a href="#">May 18, 2020</a></li>
              <li><a href="#">48 Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="assets/images/banner-item-05.jpg" alt="">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span>Nature</span>
            </div>
            <a href="post-details.html">
              <h4>Cras congue sed augue id ullamcorper</h4>
            </a>
            <ul class="post-info">
              <li><a href="#">Admin</a></li>
              <li><a href="#">May 24, 2020</a></li>
              <li><a href="#">64 Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="item">
        <img src="assets/images/banner-item-06.jpg" alt="">
        <div class="item-content">
          <div class="main-content">
            <div class="meta-category">
              <span>Lifestyle</span>
            </div>
            <a href="post-details.html">
              <h4>Suspendisse nec aliquet ligula</h4>
            </a>
            <ul class="post-info">
              <li><a href="#">Admin</a></li>
              <li><a href="#">May 26, 2020</a></li>
              <li><a href="#">72 Comments</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Banner Ends Here -->

<section class="blog-posts">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <div class="all-blog-posts">
          <div class="row">
            <?php
            if($follow){
            foreach ($posts as $post) {
            ?>
              <div class="col-lg-12">
                <?php include(BASE_PATH . '/views/posts-view.php') ?>
              </div>
            <?php
            }
          }
            ?>

          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="sidebar">
          <div class="row">
            <div class="col-lg-12">
              <div class="sidebar-item search">
                <form id="search_form" name="gs" method="GET" action="#">
                  <input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
                </form>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="sidebar-item recent-posts">
                <div class="sidebar-heading">
                  <h2>Recent Posts</h2>
                </div>
                <div class="content">
                 <?php

                 foreach($users as $user){

                  echo $user['name'].''."<a href='index.php?id={$user['id']}' class='btn btn-primary'>follow</a>";
                  
                  ?>
                  <br>
                  <?php




                 }
                 
                 
                 
                 
                 
                 ?>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="sidebar-item categories">
                <div class="sidebar-heading">
                  <h2>Categories</h2>
                </div>
                <div class="content">
                  <ul>
                    <?php
                    foreach ($categories as $category) {
                    ?>
                      <li><a href="<?= BASE_URL . '/posts.php?category_id=' . $category['id'] ?>">- <?= $category['name'] ?></a></li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="sidebar-item tags">
                <div class="sidebar-heading">
                  <h2>Tag Clouds</h2>
                </div>
                <div class="content">
                  <ul>
                    <?php
                    foreach ($tags as $tag) {
                    ?>
                      <li><a href="<?= BASE_URL . '/posts.php?tag_id=' . $tag['id'] ?>"><?= $tag['name'] ?></a></li>
                    <?php
                    }
                    ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="col-lg-12">
  <ul class="page-numbers">
    <?php
    $prevUrl = getUrl($page - 1, $category_id, $tag_id,$follow, $q);
    $nxtUrl = getUrl($page + 1, $category_id, $tag_id,$follow, $q);

    if ($page > 1) echo "<li><a href='{$prevUrl}'><i class='fa fa-angle-double-left'></i></a></li>";

    for ($i = 1; $i <= $page_count; $i++) {
      $url = getUrl($i, $category_id, $tag_id,$follow, $q);
      echo "<li class=" . ($i == $page ? "active" : "") . "><a href='{$url}'>{$i}</a></li>";
    }

    if ($page < $page_count) echo "<li><a href='{$nxtUrl}'><i class='fa fa-angle-double-right'></i></a></li>";
    ?>
  </ul>
</div>

<?php require_once('layout/footer.php') ?>