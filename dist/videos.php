<?php

/**
 * Template Name: Vídeos
 * Description: Template de Vídeos
 */
?>
<?php get_header(); ?>
<main>
    <div class="container py-4">
        <h1 class="blog-title">Vídeos</h1>
        <div class="row">
            <?php

            $channelId = get_option('contact_youtube_id');
            $rssUrl = "https://www.youtube.com/feeds/videos.xml?channel_id={$channelId}";

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $rssUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            try {
                $rssContent = curl_exec($ch);

                if ($rssContent === false) {
                    throw new Exception('Não foi possível obter o feed RSS.');
                }

                $rssXml = new SimpleXMLElement($rssContent);

                $rssArray = json_decode(json_encode($rssXml), true);

                $itemsPerPage = 12;
                $totalItems = count($rssArray['entry']);
                $totalPages = ceil($totalItems / $itemsPerPage);
                $currentPage = get_query_var('paged') ? get_query_var('paged') : 1;


                $startIndex = ($currentPage - 1) * $itemsPerPage;
                $currentItems = array_slice($rssArray['entry'], $startIndex, $itemsPerPage);

                foreach ($currentItems as $video) {
                    $id = str_replace("yt:video:", "", $video['id']);
                    $title = $video['title'];

            ?>
                    <div class="col-12 col-md-4">
                        <div class="videobox mb-4">
                            <div class="ratio ratio-16x9 bg-video">
                                <iframe
                                    src="https://www.youtube.com/embed/<?php echo $id ?>"
                                    title="YouTube video player"
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
                            <div class="video-title text-center p-3">
                                <?php echo $title; ?>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } catch (Exception $e) {
                echo 'Erro: ' . $e->getMessage();
            }
            ?>
        </div>

    </div>
    <?php if ($totalPages > 1) { ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <?php if ($currentPage == 1) {
                    ?>
                        <span class="page-link disabled">
                            <span aria-hidden="true">&laquo;</span>
                        </span>
                    <?php
                    } else { ?>
                        <a class="page-link"
                            href="<?php echo  get_permalink() . '1'; ?>"
                            title="Anterior"
                            aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    <?php } ?>
                </li>
                <?php

                for ($i = 1; $i <= $totalPages; $i++) {
                ?>
                    <li class="page-item">
                        <?php if ($i == $currentPage) { ?>
                            <div class="page-link active"><?php echo $i; ?></div>
                        <?php } else { ?>
                            <a class="page-link"
                                href="<?php echo get_permalink() . 'page/' . $i; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php } ?>
                    </li>
                <?php
                }
                ?>
                <li class="page-item">
                    <?php if ($currentPage == $totalPages) {
                    ?>
                        <span class="page-link disabled">
                            <span aria-hidden="true">&raquo;</span>
                        </span>
                    <?php
                    } else { ?>
                        <a class="page-link"
                            href="<?php echo get_permalink() . 'page/' . $totalPages; ?>"
                            title="Anterior"
                            aria-label="Anterior">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    <?php } ?>
                </li>
            </ul>
        </nav>
    <?php } ?>
</main>
<?php get_footer(); ?>