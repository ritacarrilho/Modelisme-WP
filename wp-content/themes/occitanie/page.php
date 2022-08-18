<!-- Pages template -->
<?php get_header(); ?>

<?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
    
    <h1><?php the_title(); ?></h1>
    
    <?php 
	// get_template_part('content','page', get_post_format());
	$current_slug = $wp->request;

	if($current_slug === "competitions") {
		get_template_part('content-competitions','page', get_post_format());
	} elseif($current_slug === "clubs") {
		get_template_part('content-clubs','page', get_post_format());
	}
		?>

	<?php endwhile; endif; ?>

<?php get_footer(); ?>