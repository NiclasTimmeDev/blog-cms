<?php
get_header();
get_navbar();
print_r($data);
?>
<script>
tinymce.init({
    selector: '#content-area',

});
</script>
<div class="container">
    <div class="row">
        <div class="col-12">
            <?php flash("create_alert_failure"); ?>
            <h1>Create a new post</h1>
        </div>
        <!-- START OUTER COL -->
        <form action="<?php echo URLROOT; ?>/posts/create" method="POST" enctype="multipart/form-data">
            <div class="col-12">
                <div class="row">

                    <div class="col-9">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <div class="container-fluid">
                                <div class="row no-gutters">
                                    <div class="col-12 no-gutters">
                                        <input type="text"
                                            class="form-control <?php echo (!empty($data["title_err"])) ? 'is-invalid' : ''; ?>"
                                            placeholder="Write something meaningful..." name="title"
                                            value=<?php $data["title"]; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea id="content-area"
                                class="form-control <?php echo (!empty($data["content_err"])) ? 'is-invalid' : ''; ?>"
                                rows="20" name="content" value=<?php $data["content"]; ?>></textarea>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="thumbnail">Thumbnail</label>
                            <input type="file" class="form-control-file" name="thumbnail"
                                value=<?php $data["thumbnail"]; ?>>
                        </div>
                        <input type="submit" class="btn btn-primary btn-block no-gutters" name="submit" value="Post">
                    </div>


                </div>

            </div>
        </form>
    </div>
</div>
<?php
get_footer();