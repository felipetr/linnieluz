<?php wp_footer(); ?>
</main>
<footer>
    <div id="innerfooter" class="p-4">
        <img
            title="<?php bloginfo('name'); ?>"
            class="footerlogo"
            src="<?php echo get_template_directory_uri(); ?>/assets/images/footerlogo.svg"
            alt="<?php bloginfo('name'); ?>">

        <?php
        $redes_sociais = get_option('contact_redes_sociais', array());
        if (!empty($redes_sociais)) { ?>
            <div id="socialmedias" class="mt-4">
                <?php
                foreach ($redes_sociais as $rede) { ?>
                    <a href="<?php echo esc_attr($rede['link']); ?>" title="<?php echo esc_attr($rede['nome']); ?>">
                        <i  class="<?php echo esc_attr($rede['icone']); ?>"></i>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>


    </div>
    <div id="signature" class="p-1">
        <a href="http://felipetravassos.com" title="Desenvolvido por Felipe Travassos">
            <i class="ll ll-signature"></i>
        </a>
    </div>
</footer>
</div>
</body>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/scripts.min.js"></script>

</html>