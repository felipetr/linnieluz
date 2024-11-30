<?php

/**
 * Template Name: Contato
 * Description: Template de Contato
 */

?>
<?php get_header(); ?>

<div class="container">
    <h1 class="blog-title">Contato</h1>

    <div class="row">
        <div class="col-12 col-md-8">
            <?php

            $formtag = get_option('contact_form_tag');

            $formtag = str_replace("\\", "", $formtag);
            echo do_shortcode($formtag); ?>
        </div>
        <div class="col-12 col-md-4">
            <div class="contactbox">
                <?php

                $email = get_option('contact_email');
                $telefone = get_option('contact_telefone');
                $redes_sociais = get_option('contact_redes_sociais', array());
                if ($email) { ?>
                    <div>
                        <a target="_blank"
                        title="email"
                        href="mailto:<?php echo $email; ?>">
                            <i class="lni lni-envelope-1"></i> <?php echo $email; ?>
                        </a>
                    </div>
                    <?php
                }

                $telefone = preg_replace('/\D/', '', $telefone);
                $formatedPhone = preg_replace('/^(\d{2})(\d{1})(\d{4})(\d{4})$/', '($1) $2 $3.$4', $telefone);
                if (strlen($telefone) == 11) { ?>
                    <div>
                        <a
                        target="_blank"
                        title="telefone"
                        href="https://api.whatsapp.com/send?phone=55<?php echo $telefone; ?>">
                        <i class="lni lni-whatsapp"></i>
                        <span class="d-none">Whatsapp</span> <?php echo $formatedPhone; ?>
                        </a>
                    </div>
                    <?php
                }
                foreach ($redes_sociais as $rede) { ?>
                    <div>
                        <a target="_blank"
                        title="<?php echo esc_attr($rede['nome']); ?>"
                        href="<?php echo esc_attr($rede['link']); ?>">
                        <i class="<?php echo esc_attr($rede['icone']); ?>"></i>
                            <span class="d-none"><?php echo esc_attr($rede['nome']); ?></span>
                            <?php
                            echo "@" . $rede['arroba'];

                            ?></a>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>

</div>


<?php get_footer(); ?>