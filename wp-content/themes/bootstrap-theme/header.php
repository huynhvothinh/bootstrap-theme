<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/style.css">

    <script src="/wp-content/themes/bootstrap-theme/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/wp-content/themes/bootstrap-theme/assets/js/popper.min.js"></script>
    <script src="/wp-content/themes/bootstrap-theme/assets/js/bootstrap.min.js"></script>
    
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="container">
        <?php dynamic_sidebar('lw_header_sidebar'); ?> 
    </div>