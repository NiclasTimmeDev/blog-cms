<?php
get_header();

$recent_posts = $data["recent_posts"];

?>

<div class="container">
    <section>
        <div class="row justify-content-center align-items-center">
            <div class="col-9 mb-large">
                <?php flash("create_post_success");
                flash("find_all_posts_error");
                flash("post_deleted_success");
                ?>
                <div class="flex">
                    <h1 class="header-xxl inline">Hi, <?php echo $_SESSION["user_username"]; ?></h1>
                    <a href="/users/edit">
                        <i class="fas fa-user-edit inline-icon icon-clickable"></i>
                    </a>
                </div>
            </div>

            <div class="col-9 mb-large">
                <p class="leading">How about a new post?</p>
                <a href="<?php echo URLROOT; ?>/posts/create" class="btn btn-primary text-white">Create Post</a>
            </div>
            <div class="col-9 mb-large">
                <section>
                    <h2 class="section-header">Your latest posts</h2>
                    <?php
                    // START POST LOOP
                    foreach ($recent_posts as $post) :
                        ?>
                    <div class="post">
                        <a class="primary-font" href="<?php echo URLROOT; ?>/posts/single/<?php echo $post->url; ?>">
                            <h3 class="inline primary-font"><?php echo $post->title; ?></h3>
                        </a>
                        <a class="primary-font" href="<?php echo URLROOT; ?>/posts/edit/<?php echo $post->url; ?>">
                            <i class="fas fa-edit inline-icon icon-clickable"></i>
                        </a>


                    </div>
                    <?php
                    endforeach;
                    // END POST LOOP
                    ?>
                    <a href="<?php echo URLROOT; ?>/admins/posts/all">View all</a>
                </section>


            </div>
        </div>
    </section>
</div>

<?php
get_footer();