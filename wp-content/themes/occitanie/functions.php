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

function modelisme_widget()
{
    register_sidebar(array(
        "name" => "modelisme_widget",
        "description" => __("Les widgets de l'ern", 'ern2021'),
        "id" => "modelismewidget",
        "before_widget" => "<div class='border border-info mb-3 rounded p-2'>",
        "after_widget" => "</div>",
        "before_title" => "<h4 class='widget-title'>",
        "after_title" => "</h4>"
    ));

    register_widget('WP_Widget_Weather');
}

add_action("widgets_init", "modelisme_widget");


class WP_Widget_Weather extends WP_Widget
{
    function __construct() 
    {
        $widget_ops = array (
            'classname' => 'widget_weather',
            'description' => __('Dark Ski Api meteo'),
            'customize_selective_refresh' => true,
        );
        parent::__construct('weather', __('Weather Widget', 'Weather', $widget_ops));
    }

    public function form($instance) 
    {
        $instance = wp_parse_args( (array)$instance , array(
            "lat" => '',
            "lon" => '',
            "apiToken" => '',
         ));
         ?>

         <p>
            <label for="<?php echo $this->get_field_id('lat');?>" <?php _e('Lattitude :') ?>></label>
            <input type="text" class="" id="<?php echo $this->get_field_id('lat'); ?>" name="<?php echo $this->get_field_name('lat'); ?>" value="<?php echo esc_attr( $instance['lat']); ?>">
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('lon');?>" <?php _e('Longitude :') ?>></label>
            <input type="text" class="" id="<?php echo $this->get_field_id('lon'); ?>" name="<?php echo $this->get_field_name('lon'); ?>" value="<?php echo esc_attr( $instance['lon']); ?>">
         </p>
         <p>
            <label for="<?php echo $this->get_field_id('apiToken');?>" <?php _e('apiToken :') ?>></label>
            <input type="text" class="" id="<?php echo $this->get_field_id('apiToken'); ?>" name="<?php echo $this->get_field_name('apiToken'); ?>" value="<?php echo esc_attr( $instance['apiToken']); ?>">
         </p>
    <?php 
    }

    public function update($new_instance, $old_instance) 
    {
        $instance = $old_instance;
        $instance['lat'] = sanitize_text_field( $new_instance['lat']);
        $instance['lon'] = sanitize_text_field( $new_instance['lon']);
        $instance['apiToken'] = sanitize_text_field( $new_instance['apiToken']);

        return $new_instance;
    }

    // show in front-end
    public function widget($args, $instance)
    {
        // title
        $title = 'La Méteo';
        // api request url
        $url = 'https://api.darksky.net/forecast' . $instance['apiToken'] . '/' . $instance['lat'] . ',' . $instance['lon'];

        // api request
        $request = wp_remote_get($url);

        if(is_wp_error( $request )) {
            return false;
        }

        $body = wp_remote_retrieve_body($request);
        $data = json_decode($body);
        echo $args['before_widget'];

        if($title) {
            echo $args['before-title'] . $title . $args['after-title'];
        }

        echo '<div id="meteo-wrap" class="meteo-wrap">';
        if(!empty($data)) {
            echo '<div class="'.$data->currently->icon.'">&nbsp;</div>';
            echo'<div>' . number_format((( $data->currently->temperature - 32) * (5/9)), 2, ',', ' ') . 'deg</div>';
            echo'<div>' . number_format(( $data->currently->windSpeed * 1.609), 2, ',', ' ') . 'km</div>';
        }
        
        echo'</div>';
        echo $args['after-widget'];
    }
}


// Creating the widget
class wpb_widget extends WP_Widget {
 
    function __construct() {
    parent::__construct(
     
    // Base ID of your widget
    'wpb_widget', 
     
    // Widget name will appear in UI
    __('WPBeginner Widget', 'wpb_widget_domain'), 
     
    // Widget description
    array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_widget_domain' ), )
    );
    }
     
    // Creating widget front-end
     
    public function widget( $args, $instance ) {
    $title = apply_filters( 'widget_title', $instance['title'] );
     
    // before and after widget arguments are defined by themes
    echo $args['before_widget'];
    if ( ! empty( $title ) )
    echo $args['before_title'] . $title . $args['after_title'];
     
    // This is where you run the code and display the output
    echo __( 'Hello, World!', 'wpb_widget_domain' );
    echo $args['after_widget'];
    }
     
    // Widget Backend
    public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
    $title = $instance[ 'title' ];
    }
    else {
    $title = __( 'New title', 'wpb_widget_domain' );
    }
    // Widget admin form
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <?php
    }
     
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
    return $instance;
    }
     
    // Class wpb_widget ends here
    } 

    // Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );