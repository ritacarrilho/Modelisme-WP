<!DOCTYPE html>
<html <?php language_attributes(); ?>> <!-- defines automatically the language --> 
<head>
    <meta charset="<?php bloginfo('charset'); ?>"> <!-- defines encoding --> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    
    <?php wp_head(); ?> <!-- tag title, recover scripts and styles --> 
</head>

<body <?php body_class(); ?>>
    <main class="wrapper">  
    <header class="header">
        <a href="<?php echo home_url( '/' ); ?>"> <!-- redirect to home page -->
            <h1>Occitanie Modelisme</h1>
            <!-- <img src="<?php // echo get_template_directory_uri(); ?>/img/" alt="Logo"> -->
        </a>  
    </header>
    </main>