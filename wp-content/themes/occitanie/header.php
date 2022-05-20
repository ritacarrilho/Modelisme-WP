<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
    <!-- <link rel="stylesheet" href="/styles/style.css"> -->
    <title>Occitanie Modelisme</title>
</head>
    <body>
<?php if ( get_header_image() ) : ?>
    <div id="site-header">
        <img src="<?php header_image(); ?>"
                width="<?php echo absint( get_custom_header()->width )?>px"
                height="<?php echo absint( get_custom_header()->height )?>px"/>
    </div>
<?php endif; ?>
    <header class="bg-success text-white p-3">
    <h2>
        <a href="<?php echo get_bloginfo('wpurl'); ?>" class="text-light">
        <?php echo get_bloginfo("name"); ?>
        </a>
    </h2>
    <em class="blog-description"><?php echo get_bloginfo('description'); ?></em>
    <!--    element de menu -->
<!--    <nav class="navbar navbar-expand-lg navbar-light">-->
        <?php wp_nav_menu([
                "theme_location" => "menu-sup",
                "container" => "nav",
                "container_class" => "navbar navbar-expand-lg navbar-light",
                "menu_class" => "navbar-nav  mr-auto",
                "menu_id" => " ",
                "walker" => new modelisme_walker(),
        ]); ?>
<!--    </nav>-->
    </header>
