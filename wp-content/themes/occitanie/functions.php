<?php

// global $categories;
// $categories = $wpdb->get_results("SELECT {$table_prefix}categories.name FROM {$table_prefix}categories"); 

function modelisme_setup()
{
    global $content_width; 
    if(!isset($content_width)) {
        $content_width = 1250;
    }

    add_theme_support('automatic-feed-links'); // the theme supports the feature => allows the links RSS dans les posts et comments

    add_theme_support('post-thumbnail'); // adicionar miniaturas nos articulos

    $args = [
        'default-image' => get_template_directory_uri() . '/img/default-imgage.jpg',
        'default-text-color' => '000',
        'width' => 100,
        'height' => 'auto',
        'flex-width' => true,
        'flex-height' => true,
    ];

    add_theme_support('custom-header', $args);
}

add_action('after_setup_theme', 'modelisme_setup');

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Add the site title 
add_theme_support( 'title-tag' );

// define different image sizes
// add_image_size( 'products', 800, 600, false );
// add_image_size( 'square', 256, 256, false );

function occitanie_theme_script() // add style and script files
{ 
    wp_register_style('main_style', get_template_directory_uri() . '/style.css', [], true); // style css link
    wp_enqueue_style('main_style'); 

    wp_register_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css' );
    wp_enqueue_style('font-awesome'); 

    wp_register_script('myjs', get_template_directory_uri() . '/js/myjs.js', [], true, true); //  script javascript link 
    wp_enqueue_script('myjs'); 
}

add_action('wp_enqueue_scripts', 'occitanie_theme_script');

function register_menu() // instanciate a menu reference
{
    // adds a submenu to the wp-admin interface 
    register_nav_menus(
        array(
            'main' => 'Menu Principal',
            'menu-sup' => __('Menu sup') // 'menu-sup' -> slug | 'Menu sup' -> menu title
        )
    );
}

add_action('init', 'register_menu'); // menu hook

// Register a new sidebar simply named 'sidebar'
function sidebar_widgets_init() {
    register_sidebar( array(
                    'name'          => 'Sidebar',
                    'id'            => 'sidebar',
                    'before_widget' => '<aside>',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h2>',
                    'after_title'   => '</h2>',
    ) );
}

add_action( 'widgets_init', 'sidebar_widgets_init' ); // Hook the widget initiation and run our function

// Register a new sidebar simply named 'sidebar'
function footer() {
    $categories = ['Course d’automobiles radio commandées', 'Modélisme Aérien', 'Modélisme Naval'];
    return $categories;
}

add_action( 'wp_footer', 'footer' ); // Hook the widget initiation and run our function

// TODO: metadata and posts change in front office