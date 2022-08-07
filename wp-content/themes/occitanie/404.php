<?php get_header(); 

if(get_header_image()) : ?> <!-- image banner -->
    <div id="site-header">
         <img 
            src="<?php header_image() ?>" 
            width="<?php echo absint( get_custom_header()->width ) ?>%"
            height="<?php echo absint( get_custom_header()->height ) ?>"
            >
    </div>
	<?php endif; ?>

	<div class="error">404 - Not Found</div>

<?php 
	get_template_part( 'parts/banner' ); 
	get_footer();
?>