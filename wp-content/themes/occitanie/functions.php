<?php

function occitanie_setup() {
    global $content_width; // nao declara a variavel mas sim vai buscar a referencia
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

add_action('after_setup_theme', 'ern_setup');


function occitanie_theme_script() // add style files
{ 
    // wp_register_style('boot', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', [], true); 
    // wp_enqueue_style('boot'); 

    wp_register_style('main_style', get_template_directory_uri() . '/styles/style.css', [], true);
    wp_enqueue_style('main_style'); 

    wp_register_script('main', get_template_directory_uri() . '/scripts/main.js', [], true, true); 
    wp_enqueue_script('main'); 
}

add_action('wp_enqueue_scripts', 'ern_theme_script');


function register_menu() // instanciar uma referencia do menu
{
    // faz com que haja um submenu na interface do wp-admin
    register_nav_menus(
        array(
            'menu-sup' => __('Menu sup') // 'menu-sup' -> slug | 'Menu sup' -> menu title
        )
    );
}

add_action('init', 'register_menu'); // (referencia do hook, a funçao a executar) quando a execuçao atinge os hooks, executa as funçoes definidas pelo developer