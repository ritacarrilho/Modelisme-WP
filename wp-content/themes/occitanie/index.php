<?php get_header() ?>

<main class="p-3">
    <div class="row">
        <div class="col-sm-8 blog-main">

             <?php 
                // if ( have_posts() ) : while( have_posts() ) : the_post();
                //         get_template_part('content', get_post_format());  // get_template_part('content', get_post_format())
                //     endwhile;
                // endif; 
             ?> 
        </div>

         <?php // get_sidebar();  ?> <!-- to position the sidebar-->
    </div>
</main>

<?php get_footer() ?>