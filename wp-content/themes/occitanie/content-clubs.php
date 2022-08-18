<?php

$clubs = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}clubs;"));
$members = $wpdb->get_results($wpdb->prepare("SELECT * FROM {$wpdb->prefix}adherents;"));


echo '<pre>'; print_r($clubs); echo '</pre>';
echo '<pre>'; print_r($members); echo '</pre>';

?>
<section>
    <h2>Clubs participants</h2>

    <div>
        <?php foreach($clubs as $club):
            if($club->participant == 1) { ?>
                <div>
                <?php foreach($members as $member) {
                    if($club->id === $member->club_id) { ?>
                        <h5> <?php echo $club->name?> </h5>
                        <p> <?php echo $member->first_name; echo $member->last_name?> </p>
                <?php } else { ?>
                    <h5> <?php echo $club->name?> </h5>
                    <p> Ce Club n'a pas encore de adhérents</p>
                <?php } 
                } ?>
                </div>
        <?php } 
                
         endforeach; ?>         
    </div>
</section>

<section>
    <h2>Clubs non participants</h2>
    <div>
        <?php foreach($clubs as $club):
            if($club->participant == 0) { ?>
                 <div>
           <?php foreach($members as $member) {
                 if($club->id === $member->club_id) { ?>
                    <h5> <?php echo $club->name?> </h5>
                    <p> <?php echo $member->first_name; echo $member->last_name?> </p>
            <?php } else { ?>
                    <h5> <?php echo $club->name?> </h5>
                    <p> Ce Club n'a pas encore de adhérents</p>
                <?php } 
                } ?>
                 </div> 
            <?php } 
                
        endforeach; ?>
            

             
    </div>
</section>
