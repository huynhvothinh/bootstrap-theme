<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$theme_name = 'ribeto';
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/assets/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/style.css">

    <link rel="stylesheet" href="/wp-content/themes/bootstrap-theme/themes/<?php echo $theme_name;?>/css/custom.css">

    <script src="/wp-content/themes/bootstrap-theme/assets/js/jquery-3.3.1.min.js"></script>
    <script src="/wp-content/themes/bootstrap-theme/assets/js/popper.min.js"></script>
    <script src="/wp-content/themes/bootstrap-theme/assets/js/bootstrap/bootstrap.min.js"></script>
    <script src="/wp-content/themes/bootstrap-theme/themes/<?php echo $theme_name;?>/js/custom.js"></script>
    
    <title><?php bloginfo('name'); ?> | <?php is_front_page() ? bloginfo('description') : wp_title('', true, ''); ?></title>
    <?php wp_head(); ?>
</head>
<body id="body" <?php body_class(); ?>>
    <div id="header" class="lw-header">
        <?php dynamic_sidebar('lw_header_sidebar'); ?> 
    </div>