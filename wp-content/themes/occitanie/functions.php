<?php

// Ajouter la prise en charge des images mises en avant
add_theme_support( 'post-thumbnails' );

// Ajouter automatiquement le titre du site dans l'en-tête du site
add_theme_support( 'title-tag' );


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
