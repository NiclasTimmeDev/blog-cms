<?php
get_header();

$recent_posts = $data["recent_posts"];
?>

<div class="container">
    <div class="row">

        <!-- HEADER WELCOME AREA -->
        <div class="col-12 mb-large">
            <?php flash("create_post_success");
            flash("find_all_posts_error");
            flash("post_deleted_success");
            flash("updated_navbar_success");
            ?>
            <div class="flex">
                <h1 class="header-xxl inline">Hi, <?php echo $_SESSION["user_username"]; ?></h1>
                <a href="/users/edit">
                    <i class="fas fa-user-edit inline-icon icon-clickable"></i>
                </a>
            </div>
        </div>

        <!-- LEFT SIDE -->
        <div class="col-6 mb-large">
            <div class="row">

                <!-- NEW POST -->
                <div class="col-12">
                    <section class="card card-body">
                        <h2 class="section-header">How about a new post?</h2>
                        <a href="<?php echo URLROOT; ?>/posts/create" class="btn btn-primary inline text-white">Create
                            Post</a>
                    </section>

                </div>

                <!-- RECENT POSTS -->
                <div class="col-12">
                    <section class="card card-body">
                        <h2 class="section-header">Your latest posts</h2>
                        <?php
                        // START POST LOOP
                        foreach ($recent_posts as $post) :
                            ?>
                        <div class="post flex">
                            <a class="primary-font"
                                href="<?php echo URLROOT; ?>/posts/single/<?php echo $post->url; ?>">
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
        </div>

        <!-- RIGHT SIDE -->
        <div class="col-6 mb-large">
            <section class="card card-body">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section-header">
                            Edit your page
                        </h2>
                    </div>
                </div>
                <div class="row justify-content-evently">
                    <div class="col">
                        <a href=<?php echo URLROOT . "/admins/edit/navbar";  ?>>Navigation</a>
                    </div>
                    <div class="col">
                        <a href=<?php echo URLROOT . "/admins/edit/footer";  ?>>Footer</a>
                    </div>
                </div>
            </section>



        </div>
    </div>
</div>

<?php
get_footer();