<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
    <?php if( is_home() || is_single() ) : ?>
      <h4>Recent Posts</h4>
          <ol class="list-unstyled">
<?php 
          $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 4, // Number of recent posts thumbnails to display
                'post_status' => 'publish' // Show only the published posts
            ));

            foreach( $recent_posts as $post_item ) : ?>
                <li>
                    <a href="<?php echo get_permalink($post_item['ID']) ?>">
                       <p><?php echo $post_item['post_title'] ?></p>
                    </a>
                </li>
<?php 
            endforeach; ?>
          </ol>
      <div class="sidebar-module sidebars-module-inset">
      <!-- display archives -->  
          <h4>Archives</h4>
          <ol class="list-unstyled">
              <li>
                <p><?php wp_get_archives("type=monthly"); ?></p>
              </li>
          </ol>
<!-- display categories -->
        <h4>Catégories</h4>
        <ol class="list-unstyled">
        <?php $categories = get_categories();
          foreach($categories as $category) {
            echo '<li><a href="' . get_category_link($category->term_id) . '"><p>' . $category->name . '</a></p></li>';
          } ?>
        </ol>

<!--    positionner mon emplacement de widget    -->
        <?php
            if( is_active_sidebar( 'modelisme_widget' )) :
                dynamic_sidebar('modelisme_widget');
            endif;
        ?>
    </div>
    <?php endif; ?>

</div>