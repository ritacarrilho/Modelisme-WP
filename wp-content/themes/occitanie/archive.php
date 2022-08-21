<!-- Single Post type items Template -->
<?php 
/* 
Template Name: Archives
*/

get_header(); 

if( have_posts() ) : while( have_posts() ) : the_post(); ?>
  
  <section class="posts-section-flex">
    <div class="posts-wrapper">
    <article class="post">
      <h1><?php the_title(); ?></h1>

      <?php the_post_thumbnail(); ?>

      <div class="post__meta">
        <div>
          <?php echo get_avatar( get_the_author_meta( 'ID' ), 40 ); ?>
        </div>
        
          <div>
            <p>Publié le <?php the_date(); ?></p>
            <p>Par <?php the_author(); ?></p>
            <p>Les catégories <?php the_category(); ?></p>
        </div>
      </div>

      <div class="post__content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; endif; ?>
    </div>
    <aside class="posts-sidebar">
        <?php get_sidebar('posts-sidebar'); ?>
    </aside>
</section>

<!-- previous and next post buttons -->
<section class="posts-arrow wrapper">
  <div> 
      <?php previous_post_link(); ?>
  </div>

  <div>
    <?php next_post_link(); ?>
  </div>
</section>

  <?php //get_template_part( 'parts/newsletter' ); ?>
<?php get_footer(); ?>