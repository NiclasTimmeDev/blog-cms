<?php
get_header();
?>
<div class="container edit-navbar-page">
    <div class="row mb-large">
        <div class="col-12">
            <h1>Your Navbar</h1>
            <?php flash("create_link_success");
            flash("create_link_error");
            flash("navbar_order_success");
            flash("navbar_order_err");
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="row">

                <!-- CREATE NEW NAVBAR ITEM -->
                <div class="col-12 edit-section">

                    <button id="btn-internal" class="btn btn-dark">Internal Link</button>
                    <button id="btn-external" class="btn btn-light">External Link</button>
                    <form class="add-link-form card card-body" action="<?php echo URLROOT; ?>/admins/edit/navbar_item"
                        method="POST">
                        <h3 class="header-no-mg">Create a new navbar link</h3>
                        <span class="text-muted mb-small">The link will become an option for you to display in your
                            navbar</span>
                        <div class="form-group">
                            <label for="new_item">Name</label>
                            <input type="text" class="form-control" placeholder="Enter a name" name="new_item_name"
                                value="">
                        </div>
                        <div class="form-group add-internal-link-form-link">
                            <label for="new_item">Link</label>
                            <div class="flex">
                                <span class="text-muted mr-10"><?php echo URLROOT; ?>/</span>
                                <input type="text" class="form-control inline" placeholder="Enter a link"
                                    name="new_item_internal_link" value="">
                            </div>

                        </div>
                        <div class="form-group hidden add-external-link-form-link">
                            <label for="new_item">External Link</label>

                            <div class="flex ">
                                <input type="text" class="form-control" placeholder="Enter an external link"
                                    name="new_item_external_link" value="">
                            </div>

                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Create">
                        </div>
                    </form>
                </div>

                <!-- SHOW AVAILABLE NAVBAR ITEMS -->
                <div class="col-12 edit-section">
                    <form class="card card-body" action="<?php echo URLROOT; ?>/admins/edit/navbar" method="POST">
                        <h3 class="header-no-mg">Choose items</h3>
                        <span class="text-muted mb-small">The links that will be displayed in your navbar</span>
                        <?php
                        foreach ($data as $link) :
                            ?>
                        <div class="form-check">
                            <input <?php echo $link->selected == 1 ? "Checked" : "";  ?> type="checkbox"
                                name="<?php echo $link->name ?>" value="<?php echo $link->link ?>"
                                class="form-check-input">
                            <label class="form-check-label"
                                for="<?php echo $link->name ?>"><?php echo $link->name ?></label>
                        </div>
                        <?php endforeach; ?>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Save">
                        </div>
                    </form>

                </div>
            </div>

        </div>
        <div class="col-6">
            <form action="<?php echo URLROOT; ?>/admins/edit/navbar_order" method="POST">
                <div class="col-12 drag-container card card-body">

                    <h3 class="header-no-mg">Order your navbar items</h3>
                    <span class="text-muted mb-small">The order of your navbar items</span>
                    <?php foreach ($data as $link) : ?>
                    <div class="flex navbar-drag-item" draggable="true">
                        <i class="fas fa-grip-lines text-info"></i>
                        <div><?php echo $link->name ?></div>
                        <input type="hidden" name="<?php echo $link->name; ?>" value=<?php echo $link->name;  ?>>
                    </div>
                    <?php endforeach; ?>
                </div>
                <input type="submit" class="btn btn-primary inline" value="Save">
            </form>
        </div>
    </div>
</div>

<?php
get_footer();