    <?php require('wp-load.php'); ?>
    <footer>
        <?php wp_footer();  // recover scripts and styles
        ?>

        <div class="footer-info">
            <div class="footer-info-element">
                <h4>L'occitanie</h4>
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.</p> 
                <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything.</p>
            </div>

            <div class="footer-info-element">
                <h4>Nous Modélismes</h4>
            <?php 
                // get all posts categories
                $categories = get_categories();

                foreach($categories as $category) {
                    if($category->name != "Modelisme") {
                       echo '<p>' . $category->name . '</p>'; 
                    }
                } ?>
            </div>

            <div class="footer-info-element">
                <h4>Tags</h4>
                <p>apps blog blogroll christmas cms coda concert daily design develop dialog drinks envato food fun gallery gift holiday icon illustration ipad iphone journal jquery label link marketing mobile motion music photo  profession quotation recipes show sound strategy tv typography video</p>
            </div>

            <div class="footer-info-element">
                <h4>Contactez nous</h4>
                <p>Lorem Ipsum is simply dummy of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since.</p>

                <div class="footer-info-element-icons">
                    <div>
                        <i class="fa-solid fa-location-dot"></i>
                        <p>Occitanie, France</p>
                    </div>
                    <div>
                        <i class="fa-solid fa-envelope"></i>
                        <p>modelisme@mail.com</p>
                    </div>                    
                    <div>
                        <i class="fa-solid fa-phone"></i>
                        <p>+33 07 49 38 29 30</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-rights">
            <p>&copy; <?php echo date("Y"); ?> Occitanie Modelisme. All rights reserved. Theme by Rita</p>
            <div class="network-icons">
                <a href="">
                   <i class="fa-solid fa-rss"></i> 
                </a>
                <a href="">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="">
                    <i class="fa-brands fa-linkedin-in"></i>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>