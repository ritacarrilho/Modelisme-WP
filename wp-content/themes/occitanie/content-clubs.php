<?php

$clubs = $wpdb->get_results($wpdb->prepare("SELECT {$wpdb->prefix}clubs.id, {$wpdb->prefix}clubs.participant, {$wpdb->prefix}clubs.name, {$wpdb->prefix}categories.name as category
                                            FROM {$wpdb->prefix}clubs
                                            JOIN {$wpdb->prefix}categories
                                            ON {$wpdb->prefix}clubs.domain = {$wpdb->prefix}categories.id;"));

$members = $wpdb->get_results($wpdb->prepare("SELECT {$wpdb->prefix}clubs.id as club, {$wpdb->prefix}adherents.id as member, {$wpdb->prefix}adherents.first_name, {$wpdb->prefix}adherents.last_name, {$wpdb->prefix}adherents.club_number, {$wpdb->prefix}adherents.email
                                                FROM {$wpdb->prefix}clubs
                                                JOIN {$wpdb->prefix}adherents 
                                                ON {$wpdb->prefix}clubs.id = {$wpdb->prefix}adherents.club_id;"));

// $count_members = $wpdb->get_results("SELECT COUNT({$wpdb->prefix}adherents.id) FROM {$wpdb->prefix}adherents;");

// array with clubs ids from table members
$clubs_with_members_id = array_column($members, 'club');
// array with all club's id
$all_clubs_id = array_column($clubs, 'id');
// array with clubs id with members
$res = array_intersect($all_clubs_id, $clubs_with_members_id);

//  var_dump($count_members);
// echo '<pre>'; print_r($members); echo '</pre>';
?>

<main class="clubs">
    <section id="home-p" class="wrapper">
        <h2 style="padding-bottom: 35px;">Voici les <span>clubs participants</span> à nos compétitions.</h2>

        <div class="clubs-grid">
            <?php 
            if(isset($clubs)) :
                foreach($clubs as $club) :?>
                    <?php if($club->participant == 1) { ?>
                        <div>
                            <h4><?php echo $club->name?></h4> 
                            <h6 class="h6-category">Catégorie: <span> <?php echo $club->category ?> </span></h6>
                                <?php foreach($members as $member) {
                                    if(isset($member->club) && $club->id == $member->club) { ?>
                                        <p> Nom: <?php echo "{$member->first_name} {$member->last_name}"?> </p>
                                        <small> Nombre d'adhérent:  <?php echo $member->club_number ?> </small>
                                <?php } 
                                }
                            
                                if(!in_array($club->id, $res)) { ?> 
                                    <p> Ce Club n'a pas encore de adhérents</p>
                            <?php }
                        } ?>
                        </div>
            <?php endforeach; 
            endif; ?>         
        </div>
    </section>

    <!-- <section>
        <h2>Clubs non participants</h2>

        <div>
            <?php 
            /* if(isset($clubs)) :
                foreach($clubs as $club) :?>
                    <?php if($club->participant == 0) { ?>
                        <div>
                            <h4><?php echo $club->name?></h4> 
                                <?php foreach($members as $member) {
                                    if(isset($member->club) && $club->id == $member->club) { ?>
                                        <p> <?php echo "{$member->first_name} {$member->last_name}"?> </p>
                                        <small> <?php echo $member->club_number ?> </small>
                                <?php } 
                                }
                            
                                if(!in_array($club->id, $res)) { ?> 
                                    <p> Ce Club n'a pas encore de adhérents</p>
                            <?php }
                        } ?>
                        </div>
            <?php endforeach; 
            endif; */ ?>         
        </div>
    </section> -->

</main>