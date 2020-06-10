<?php
get_header();
?>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>All your posts</h1>
            </div>

            <?php
            foreach ($data as $post) {
                ?>
            <div class="col-12">
                <div class="post">
                    <div class="flex">
                        <a class="primary-font" href="<?php echo URLROOT; ?>/posts/single/<?php echo $post->url; ?>">
                            <h3 class="inline primary-font"><?php echo $post->title; ?></h3>
                        </a>
                        <a class="primary-font" href="<?php echo URLROOT; ?>/posts/edit/<?php echo $post->url; ?>">
                            <i class="fas fa-edit inline-icon icon-clickable"></i>
                        </a>
                    </div>

                    <p>
                        <?php echo filter_var(substr($post->content, 0, 50), FILTER_SANITIZE_STRING); ?>...
                    </p>
                    <?php $date = date_create($post->date); ?>
                    <small class="text-muted">Posted on <?php echo date_format($date, "d.m.Y"); ?></small>
                </div>
            </div>

            <?php
            }
            ?>
        </div>
    </div>
</section>


<?php
get_footer();