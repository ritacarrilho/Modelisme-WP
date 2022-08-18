<!-- Home Page -->
<?php 
    require_once("wp-load.php");

    // get all modelisme categories
    $cat_id = $wpdb->get_results("SELECT {$wpdb->prefix}categories.id FROM {$wpdb->prefix}categories;");

    $compets = $wpdb->get_results($wpdb->prepare("SELECT {$wpdb->prefix}competitions.name as compet, {$wpdb->prefix}competitions.category_id, {$wpdb->prefix}categories.name as category 
                                                FROM {$wpdb->prefix}competitions 
                                                JOIN {$wpdb->prefix}categories 
                                                ON {$wpdb->prefix}competitions.category_id = {$wpdb->prefix}categories.id;"));

    // get all posts categories
    $categories = get_categories( array(
        'orderby' => 'name',
        'order'   => 'ASC'
    ) );

    
    // echo '<pre>'; print_r($compets); echo '</pre>';
    // echo '<pre>'; print_r($cat_id); echo '</pre>';

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
        <p><?= $categories[0]->description ?></p>

        <div class="home-aside-wrapper">
            <div class="home-grid">
                <?php for( $i = 0; $i < count($cat_id); $i++ ): ?>
                    <div>
                    <?php if($cat_id[$i]->id == 1) {?>
                            <i class="fa-solid fa-car-side"></i>
                            <h5><?php echo $compets[$i]->category;?></h5>
                            <?php foreach($compets as $compet) {
                                if($compet->category_id == 1) {?>
                                <p class="p"><?php echo $compet->compet; ?></p>
                            <?php } }
                            
                    } elseif($cat_id[$i]->id == 2) {?>
                            <i class="fa-solid fa-jet-fighter"></i>
                            <h5><?php echo $compets[$i]->category;?></h5>
                            <?php foreach($compets as $compet) {
                                if($compet->category_id == 2) {?>
                                <p class="p"><?php echo $compet->compet; ?></p>
                            <?php }}
                    } elseif($cat_id[$i]->id == 3) {?>
                            <i class="fa-solid fa-sailboat"></i>
                            <h5><?php echo $compets[$i]->category;?></h5>
                            <?php foreach($compets as $compet) {
                                if($compet->category_id == 3) {?>
                                <p class="p"><?php echo $compet->compet; ?></p>
                            <?php }}
                        } else {?>
                            <p class="p">Pas de competitions en ce moment...</p>
                    <?php }    
                    ?>
            </div>
                <?php endfor ?>
        </div>

        <?php get_sidebar(); ?>
        </div>
    </section>

    <section id="home-images-grid" class="wrapper">
        <h2>Les types de modélisme</h2>
        <div class="home-articles-grid">
        <?php 
            foreach($categories as $category) : 
                if($category->slug != 'modelisme') :
        ?>
            <div class="grid-el">
                <img src=" <?= esc_url( get_template_directory_uri() .'/img/' . $category->slug . '.jpg') ?>" alt="<?= $category->name; ?>">
                <h5><?= $category->name ?></h5>
                <p><?= $category->description ?></p>
            </div>
            <?php endif; endforeach; ?>
        </div>

    </section>

<?php 
    get_template_part( 'parts/banner' ); 
?>

</main>

<?php     
    get_footer(); 
?>