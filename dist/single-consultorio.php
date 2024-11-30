<?php get_header(); ?>
<div class="container">
    <?php if (have_posts()) : ?>
        <?php while (have_posts()) :
            the_post(); ?>

            <h1 class="blog-title"><?php the_title(); ?></h1>

            <?php
            $video = get_post_meta($post->ID, '_video', true);
            if ($video) {
                $videoID = explode('v=', $video)[1];
                ?>
                <hr>
                <div class="row justify-content-center">

                    <div class=" col-12 col-md-6">
                        <div class="ratio ratio-16x9 bg-video">
                            <iframe
                                src="<?php
                                        echo "https://www.youtube.com/embed/" . $videoID;
                                ?>"
                                title="YouTube video player"
                                class="w100 videoIframe"
                                frameborder="0"
                                allow="accelerometer;
                                    autoplay;
                                    clipboard-write;
                                    encrypted-media;
                                    gyroscope;
                                    picture-in-picture;
                                    web-share"
                                referrerpolicy="strict-origin-when-cross-origin"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class=" col-12 col-md-6">
                        <hr>
                        <?php the_content(); ?>
                    </div>
                </div>

            <?php } ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <hr>

                    <?php
                    $text = '<div>' . get_post_meta($post->ID, '_endereco', true) . '</div>';
                    if (get_post_meta($post->ID, '_telefone', true)) {
                        $text .= '<div> Telefone: ' . get_post_meta($post->ID, '_telefone', true) . '</div>';
                    }
                    if (get_post_meta($post->ID, '_email', true)) {
                        $text .= '<div> E-mail: ' . get_post_meta($post->ID, '_email', true) . '</div>';
                    }

                    echo $text;


                    ?>
                </div>

            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <hr>
                    <div class="ratio ratio-16x9 bg-video">
                        <?php
                        $latitude = get_post_meta($post->ID, '_latitude', true);
                        $longitude = get_post_meta($post->ID, '_longitude', true);
                        ?>
                        <iframe
                            frameborder="0"
                            scrolling="no"
                            marginheight="0"
                            marginwidth="0"
                            title="Mapa"
                            src="https://maps.google.com/maps?q=<?php
                                                                echo $latitude
                            ?>,<?php
                                                                    echo
                                                                    $longitude
?>&hl=es&z=14&amp;output=embed">
                        </iframe>
                    </div>
                </div>
            </div>


        <?php endwhile; ?>
        <?php wp_reset_query(); ?>

    <?php endif; ?>

    <?php comments_template('', true); ?>
</div>
<?php get_footer(); ?>