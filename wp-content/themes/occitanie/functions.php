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

/* STYLECHEETS ANS SCRIPTS */
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

/* MENUS */
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

/* SIDE BARS */
function register_sidebars_modelisme() {
    // posts sidebar
    register_sidebar( array(
                    'name'          => 'Posts Sidebar',
                    'id'            => 'posts-sidebar',
                    'before_widget' => '<aside>',
                    'after_widget'  => '</aside>',
                    'before_title'  => '<h2>',
                    'after_title'   => '</h2>',
    ) );

    // competitions sidebars
    register_sidebar( array(
        'name'          => 'Compets Sidebar',
        'id'            => 'compets-sidebar',
        'before_widget' => '<aside>',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );

    // footer sidebars
    register_sidebar( array(
        'name'          => 'Footer Sidebar',
        'id'            => 'footer-sidebar',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );
}

add_action( 'widgets_init', 'register_sidebars_modelisme' ); // Hook the widget initiation and run the function

/* WIDGETS */
class modelisme_widget extends WP_Widget {

    function __construct() {
        parent::__construct( // widget processses
            'modelisme_widget', // widget ID
            __('Competitions Scores', 'modelisme_widget_domain'), // widget name
            array ( 'description' => __( 'Les scores des competitions', 'modelisme_widget_domain' ), ) // widget description
        );
    }

    public function widget( $args, $instance ) { // output the content of the widget
        $title = apply_filters( 'widget_title', $instance['title'] );
        echo $args['before widget'];

        //if title is present
        if ( ! empty ( $title ) )
        echo $args['before_title'] . $title . $args['after_title'];
        //output
        echo __( 'Ici Competitions Scores', 'modelisme_widget_domain' );
        echo $args['after_widget'];
    }

    public function form( $instance ) { // output the options form in the admin
        if ( isset( $instance[ 'title' ] ) )
        $title = $instance[ 'title' ];
        else
        $title = __( 'Default Title', 'modelisme_widget_domain' );
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) { // process widget options to be saved
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        return $instance;
    }
}

function modelisme_register_widget() { // register the widget
    register_widget( 'modelisme_widget' );
}
    
add_action( 'widgets_init', 'modelisme_register_widget' );


/* Woocommerce */
function modelisme_add_woocommerce_support() {
    add_theme_support( 'woocommerce', array(
        'thumbnail_image_width' => 150,
        'single_image_width'    => 300,

        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 2,
            'max_rows'        => 8,
            'default_columns' => 3,
            'min_columns'     => 2,
            'max_columns'     => 5,
        ),
    ) );
}

add_action( 'after_setup_theme', 'modelisme_add_woocommerce_support' );

add_theme_support( 'wc-product-gallery-zoom' );
add_theme_support( 'wc-product-gallery-lightbox' );
add_theme_support( 'wc-product-gallery-slider' );

/**
 * Show cart contents / total Ajax
 */
add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

function woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;

	ob_start();

	?>
	<a class="cart-customlocation" href="<?php echo esc_url(wc_get_cart_url()); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
	<?php
	$fragments['a.cart-customlocation'] = ob_get_clean();
	return $fragments;
}