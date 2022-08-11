<?php get_header(); 
?>

	<div class="error wrapper">
        <img src=" <?= esc_url( get_template_directory_uri() .'/img/404.jpg') ?>" alt="404 Not Found" style="width: 100%">
        <h5>Page Not Found</h5>
    </div>

<?php 
	get_footer();
?>