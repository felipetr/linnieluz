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
                        <span class="d-none"><?php echo esc_attr($rede['nome']); ?></span>
                    </a>
                <?php } ?>
            </div>
        <?php } ?>


    </div>
    <div id="signature" class="p-1">
        <a href="http://felipetravassos.com" title="Desenvolvido por Felipe Travassos">
            <span class="d-none">Desenvolvido por Felipe Travassos</span>
            <i class="ll ll-signature"></i>
        </a>
    </div>
</footer>
</div>
<?php if (get_option('contact_telefone')) { ?>
    <a
    href="https://api.whatsapp.com/send?phone=55<?php echo get_option('contact_telefone'); ?>"
    class="whatsappBtn"
    title="Whatsapp"
    target="_blank">
    <i class="fab fa-whatsapp"></i>
    <span class="d-none">Whatsapp</span>
    </a>
<?php } ?>
<div class="modal fade" id="siteModal" tabindex="-1" aria-labelledby="siteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="siteModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-green" data-bs-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
</body>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/scripts.min.js"></script>

</html>