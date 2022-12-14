<!DOCTYPE html>
<html <?php language_attributes(); ?>> <!-- defines automatically the language --> 
<head>
    <meta charset="<?php bloginfo('charset'); ?>"> <!-- defines encoding --> 
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    
    <?php wp_head(); ?> <!-- tag title, recover scripts and styles --> 
</head>

<body <?php body_class(); ?>>
    <header class="header">
        <div class="logo-container">
            <a href="<?php echo home_url( '/' ); ?>"> <!-- redirect to home page -->
                <p id="logo">Occitanie <span>Modelisme</span></p>
            </a> 

            <div class="network-icons">
                <a href="">
                <i class="fa-solid fa-rss"></i> 
                </a>
                <a href="">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
            </div>
        </div>


        <?php wp_nav_menu([ // menu
                "theme_location" => "menu-sup",
                "container" => "nav", // create nav element
                "menu_class" => "navbar", // define a css class to style the menu
                "menu_id" => "menu",
        ]); ?>
    </header>