<?php get_header(); ?>

<?php if(get_header_image()) : ?> <!-- imahe banner -->
    <div id="site-header">
         <img 
            src="<?php header_image() ?>" 
            width="<?php echo absint( get_custom_header()->width ) ?>%"
            height="<?php echo absint( get_custom_header()->height ) ?>"
            >
    </div>

	<div class="home-title-wrapper">
		<span class="home-title">Bienvenue au Modélisme Interdépartemental de l’Occitanie</span>
	</div>
    
    <?php endif; ?>

	<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
    	<h1><?php the_title(); ?></h1>
    
    	<?php the_content(); ?>

	<?php endwhile; endif; 

	get_template_part( 'parts/banner' ); ?>

<?php get_footer(); ?>