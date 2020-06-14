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

        <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data->url ?>" method="POST"
            enctype="multipart/form-data">
            <div class="col-12">
                <div class="row">

                    <!-- LEFT SIDE OF PAGE -->
                    <div class="col-9">
                        <div class="form-group">
                            <!-- TITLE -->
                            <label for="title">Title</label>
                            <div class="container-fluid">
                                <div class="row no-gutters">
                                    <div class="col-12 no-gutters">
                                        <input type="text" class="form-control"
                                            placeholder="Write something meaningful..." name="title"
                                            value=<?php echo $data->title; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- WYSIWYG CONTENT AREA -->
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content-area" class="form-control" rows="20" name="content"
                                value=<?php echo $data->content; ?>></textarea>
                        </div>
                    </div>

                    <!-- RIGHT SIDE OF PAGE -->
                    <div class="col-3">
                        <div class="col-12">
                            <div class="form-group">

                                <!-- THUMBNAIL -->
                                <label for="thumbnail">Thumbnail</label>
                                <img class="edit-thumb" src=<?php echo UPLOADS_ROOT . "/" . $data->thumb_url; ?> />
                                <input type="file" class="form-control-file" name="thumbnail" value="" ; ?>
                            </div>

                            <!-- SAVE -->
                            <input type="submit"
                                class="btn btn-primary btn-block no-gutters full-width edit-btn mb-small" name="submit"
                                value="Save">

                            <!-- DELETE -->
                            <form action="<?php echo URLROOT; ?>/posts/delete/<?php echo $data->url ?>" method="POST">
                                <button class="btn btn-danger full-width"><i class="fas fa-trash-alt"></i> Delete
                                    Post</button>
                            </form>
                        </div>

                    </div>


                </div>

            </div>

        </form>
    </div>
</div>

<?php
get_footer();