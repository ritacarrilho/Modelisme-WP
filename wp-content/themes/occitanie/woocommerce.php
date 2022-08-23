<?php 
get_header(); 

$categories = get_categories();
          foreach($categories as $category) {
            echo '<li><a href="' . get_category_link($category->term_id) . '"><p>' . $category->name . '</a></p></li>';
          } 

if ( have_posts() ) : ?>
    <section class="wrapper" id="woocommerce">
    <?php woocommerce_content(); ?>
    </section>
<?php endif; ?>
<section class="posts-arrow wrapper">
    <div> 
        <?php previous_post_link(); ?>
    </div>

    <div>
    <?php next_post_link(); ?>
    </div>
</section>
<?php
    get_footer();
?>