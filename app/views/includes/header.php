<!doctype html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/5c54fb25e1.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
        <script src="https://cdn.tiny.cloud/1/<?php echo TINYMCE_API_KEY; ?>/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
        <title><?php echo SITENAME ?></title>
    </head>

    <body>

        <?php
    require_once(APPROOT . "/controllers/Navbar.php");
    $navbar = new Navbar();