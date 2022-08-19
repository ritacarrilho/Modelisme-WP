<!-- Competitions and point's tables content -->

<?php 
    // get all modelisme categories
    $cat_id = $wpdb->get_results("SELECT {$wpdb->prefix}categories.id FROM {$wpdb->prefix}categories;");

    $compets = $wpdb->get_results($wpdb->prepare("SELECT {$wpdb->prefix}competitions.name as compet, {$wpdb->prefix}competitions.category_id, {$wpdb->prefix}categories.name as category 
                                                FROM {$wpdb->prefix}competitions 
                                                JOIN {$wpdb->prefix}categories 
                                                ON {$wpdb->prefix}competitions.category_id = {$wpdb->prefix}categories.id;"));

    $points = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}points;");

    // echo '<pre>'; print_r($points); echo '</pre>';

?>
<main>
    <section id="home-p" class="wrapper">
        <h2 style="padding-bottom: 35px;">Voici le <span>système de points</span> de chaque competition.</h2>

        <div>
            <div class="home-grid">
                <!-- each competition -->
                <?php for( $i = 0; $i < count($cat_id); $i++ ): ?>
                    <div class="card-wrapper">
                    <?php if($cat_id[$i]->id == 1) {?>
                            <i class="fa-solid fa-car-side"></i>
                            <?php foreach($compets as $compet) {
                                if($compet->category_id == 1) {?>
                                <h5 class="p" id="h5-points"><?php echo $compet->compet; ?></h5>
                                <?php foreach($points as $point) {
                                        if($point->id_competition == $compet->category_id) {?>
                                            <p id="points-padding"> <?php echo $point->place ?> Place: <?php echo $point->point_value ?> points</p>
                                    <?php }
                                    }?>
                            <?php } }
                            
                    } elseif($cat_id[$i]->id == 2) {?>
                            <i class="fa-solid fa-jet-fighter"></i>
                            <?php foreach($compets as $compet) {
                                if($compet->category_id == 2) {?>
                                <h5 class="p" id="h5-points"><?php echo $compet->compet; ?></h5>
                                <?php foreach($points as $point) {
                                        if($point->id_competition == $compet->category_id) {?>
                                            <p id="points-padding"> <?php echo $point->place ?> Place: <?php echo $point->point_value ?> points</p>
                                    <?php }
                                    }?>
                            <?php } }
                    } elseif($cat_id[$i]->id == 3) {?>
                            <i class="fa-solid fa-sailboat"></i>
                            <?php foreach($compets as $compet) {
                                if($compet->category_id == 3) {?>
                                <h5 class="p" id="h5-points"><?php echo $compet->compet; ?></h5>
                                <?php foreach($points as $point) {
                                        if($point->id_competition == $compet->category_id) {?>
                                            <p id="points-padding"> <?php echo $point->place ?> Place: <?php echo $point->point_value ?> points</p>
                                    <?php }
                                    }?>
                            <?php } }
                        } else {?>
                            <p class="p">Pas de competitions en ce moment...</p>
                    <?php }    
                    ?>
            </div>
                <?php endfor ?>
        </div>
    </section>
</main>