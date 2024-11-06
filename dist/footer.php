<?php wp_footer(); ?>
</main>
<footer>
    <div id="innerfooter">
            <img title="<?php bloginfo('name'); ?>" class="footerlogo" src="<?php echo get_template_directory_uri(); ?>/assets/images/footerlogo.svg" alt="<?php bloginfo('name'); ?>">
            <div id="socialmedias">
                <a href="#" title="Instagram">
                <i class="lni lni-instagram"></i>
                </a>
            </div>    
    </div>
    <div id="signature">
    <a href="http://felipetravassos.com" title="Desenvolvido por Felipe Travassos"><img class="signature" src="<?php echo get_template_directory_uri(); ?>/assets/images/dev.svg" alt="Felipe Travassos"></a>     
    </div>
</footer>
</div>
</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="<?php echo get_template_directory_uri(); ?>/lib/cleanalert.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/scripts.js"></script>

</html>