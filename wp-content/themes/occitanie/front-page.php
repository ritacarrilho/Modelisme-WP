<!-- Home Page -->
<?php 
    get_header(); 
?>

<main>
<?php if(get_header_image()) : ?> <!-- image banner -->
    <div id="site-header">
         <img 
            src="<?php header_image() ?>" 
            width="<?php echo absint( get_custom_header()->width ) ?>%"
            height="<?php echo absint( get_custom_header()->height ) ?>"
            >
    </div>

	<div class="home-title-wrapper">
		<span class="home-title">Modélisme Interdépartemental de l’Occitanie</span>
	</div>
    
    <?php endif; ?>

    <section id="home-p" class="wrapper">
        <h2>Lorem Ipsum is <span>simply dummy</span> of the printing.</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make atype specimen book. It has survived not only five centuries.</p>

        <div class="home-grid">
            <div>
                <i class="fa-solid fa-car-side"></i>
                <h5>Course d’automobiles radio commandées</h5>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting of the industry. Lorem Ipsum has been</p>
            </div>

            <div>
                <i class="fa-solid fa-jet-fighter"></i>
                <h5>Modélisme Aérien</h5>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting of the industry. Lorem Ipsum has been</p>
            </div>

            <div>
                <i class="fa-solid fa-sailboat"></i>
                <h5>Modélisme Naval</h5>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting of the industry. Lorem Ipsum has been</p>
            </div>
        </div>
        <?php get_sidebar(); ?>
    </section>

    <section id="home-images-grid" class="wrapper">
        <h2>Les types de modélisme</h2>
        <div class="home-articles-grid">
        <?php 
            // get all posts categories
            $categories = get_categories( array(
                'orderby' => 'name',
                'order'   => 'ASC'
            ) );

            foreach($categories as $category) : 
            //     echo '<pre>'; 
            //     var_dump($category->name);  
            //     echo '</pre>';
        ?>
            <div class="grid-el">
                <img src=" <?= esc_url( get_template_directory_uri() .'/img/' . $category->slug . '.jpg') ?>" alt="<?= $category->name; ?>">
                <h5><?= $category->name ?></h5>
                <p><?= $category->description ?></p>
            </div>
            <?php endforeach; ?>
        </div>

    </section>

<?php 
    get_template_part( 'parts/banner' ); 
?>

</main>

<?php     
    get_footer(); 
?>