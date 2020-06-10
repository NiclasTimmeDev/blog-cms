<?php
get_header();
get_navbar();
?>

<script>
tinymce.init({
    selector: '#content-area',

});
</script>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php flash("create_alert_failure");
            flash("edit_success");
            flash("edit_error");
            flash("delete_post_error");
            ?>

            <h1>Edit your post</h1>
        </div>
        <div class="col-12">
            <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data->url ?>" method="POST">
                <div class="form-group">
                    <label for="title">Title</label>
                    <div class="container-fluid">
                        <div class="row no-gutters">
                            <div class="col-10 no-gutters">
                                <input type="text" class="form-control" placeholder="Write something meaningful..."
                                    name="title" value=<?php echo $data->title; ?>>
                            </div>

                            <div class="col-2">
                                <input type="submit" class="btn btn-primary btn-block no-gutters" name="submit"
                                    value="Save">
                            </div>
                            <div class="col-12">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea id="content-area" class="form-control" rows="20" name="content"
                        value=<?php $data->content; ?>><?php echo $data->content; ?></textarea>
                </div>
            </form>
        </div>
        <div class="col">
            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data->url ?>" method="POST">
                <button class="btn btn-danger"><i class="fas fa-trash-alt"></i> Delete Post</button>
            </form>

        </div>
    </div>
</div>

<?php
get_footer();