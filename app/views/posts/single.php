<?php
get_header();
get_navbar();
?>

<section class="hero-section half-screen">
    <?php flash("edit_success"); ?>
    <div class="hero-content-bundle hero-content-bundle-l center">
        <img class="single-thumbnail" src=<?php echo UPLOADS_ROOT . "/" . $data->thumb_url; ?> />
        <h1><?php echo $data->title ?></h1>
    </div>
</section>

<section>
    <article>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <?php echo $data->content ?>
                </div>
                <div class="col-8">
                    <section class="meta">
                        <?php $date = date_create($data->date); ?>
                        <small class="text-muted">Posted on <?php echo date_format($date, "d.m.Y"); ?></small>
                    </section>
                </div>
            </div>
        </div>
    </article>
</section>



<?php
get_footer();