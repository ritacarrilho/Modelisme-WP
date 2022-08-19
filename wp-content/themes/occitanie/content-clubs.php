<?php

$clubs = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}clubs;"));
$members = $wpdb->get_results($wpdb->prepare("SELECT {$wpdb->prefix}clubs.id as club, {$wpdb->prefix}adherents.id as member, {$wpdb->prefix}adherents.first_name, {$wpdb->prefix}adherents.last_name
                                                FROM {$wpdb->prefix}clubs
                                                JOIN {$wpdb->prefix}adherents 
                                                ON {$wpdb->prefix}clubs.id = {$wpdb->prefix}adherents.club_id;"));

// array with ids from clubs with members
$clubs_with_members_id = array_column($members, 'club');
$all_clubs_id = array_column($clubs, 'id');

$res = array_intersect($all_clubs_id, $clubs_with_members_id);
var_dump($res);

// var_dump($object_id);
echo '<pre>'; print_r($clubs_with_members_id); echo '</pre>';
echo '<pre>'; print_r($all_clubs_id); echo '</pre>';

// echo '<pre>'; print_r($clubs); echo '</pre>';
// echo '<pre>'; print_r($members); echo '</pre>';

?>
<section>
    <h2>Clubs participants</h2>

    <div>
        <?php 
        if(isset($clubs)) :
            foreach($clubs as $club) :?>
                <?php if($club->participant == 1) { ?>
                    <div>
                        <h5><?php echo $club->name?></h5> 
                            <?php foreach($members as $member) {
                                if(isset($member->club) && $club->id == $member->club) { ?>
                                    <p> <?php echo "{$member->first_name} {$member->last_name}"?> </p>
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


<section>
    <h2>Clubs non participants</h2>

    <div>
        <?php 
        if(isset($clubs)) :
            foreach($clubs as $club) :?>
                <?php if($club->participant == 0) { ?>
                    <div>
                        <h5><?php echo $club->name?></h5> 
                    <?php foreach($members as $member) {
                                if(isset($member->club) && $club->id == $member->club) { ?>
                                    <p> <?php echo "{$member->first_name} {$member->last_name}"?> </p>
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