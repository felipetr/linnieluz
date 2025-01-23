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
        <div>
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


                $rssArray = explode("<entry>", $rssContent);
                array_shift($rssArray);

                $descriptions = [];
                foreach ($rssArray as $entry) {

                    $htmlentry = htmlentities('<entry>' . $entry);
                    $getid = explode("videoId", $htmlentry);
                    $id = str_replace("&lt;/yt:", "", $getid[1]);
                    $id = str_replace("&gt;", "", $id);


                    $getdesccription = explode("media:description", $htmlentry);
                    $description = str_replace("&lt;/", "", $getdesccription[1]);
                    $description = str_replace("&gt;", "", $description);

                    if (strlen($description) > 300) {
                        $description = substr($description, 0, 300) . "...";
                    }
                    $descriptions[$id] = htmlspecialchars_decode($description);
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
                    $resume = $descriptions[$id];


                    $thumb = "https://i4.ytimg.com/vi/" . $id . "/hqdefault.jpg";
            ?>

                    <?php


                    ?>

                    <div class="postarchive p-relative">
                        <div class="row">
                            <div class="col-12 col-lg-4">
                                <figure class="postarchive-figure">
                                    <img class="d-none d-md-block"
                                        style="background-image: url(<?php echo esc_url($thumb); ?>);"
                                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/16p9.png"
                                        title="<?php echo esc_attr($title); ?>" alt="<?php echo esc_attr($title); ?>">
                                    <img class="d-block d-md-none"
                                        style="background-image: url(<?php echo esc_url($thumb); ?>);"
                                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/16p9.png"
                                        title="<?php echo esc_attr($title); ?>" alt="<?php echo esc_attr($title); ?>">
                                </figure>
                            </div>
                            <div class="col-12 col-lg-8">
                                <div class="p-4">
                                    <h3 class="postarchivetitle text-center text-lg-start"><?php echo esc_html($title); ?></h3>
                                    <div class="postarticleresume d-none d-xl-block">
                                        <small>
                                            <?php echo nl2br($resume); ?>
                                        </small>

                                    </div>
                                    <button class="modal-btn-video btn green-rounded-btn d-block d-lg-none">
                                        Assista
                                        <div class="modal-title d-none"><?php echo esc_attr($title); ?></div>
                                        <div class="modal-content d-none"><?php echo esc_attr($id); ?></div>
                                    </button>
                                    <div class="d-none d-lg-block">
                                        <div class="row buttonrow">
                                            <div class="col-12 col-md-8"></div>
                                            <div class="col-12 col-md-4">
                                                <div class="p-4">
                                                    <button class="modal-btn-video btn green-rounded-btn">
                                                        Assista
                                                        <div class="modal-title d-none"><?php echo esc_attr($title); ?></div>
                                                        <div class="modal-content d-none"><?php echo esc_attr($id); ?></div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>




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

<div class="modal fade" id="siteModalVideo" tabindex="-1" aria-labelledby="siteModalVideoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="siteModalVideoLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9 bg-video">
                    <iframe
                        src=""
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
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-green" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script>
    const siteModalVideo = new bootstrap.Modal(
        document.getElementById("siteModalVideo"), {}
    );

    document.addEventListener("click", function(event) {
        if (event.target.closest(".modal-btn-video")) {
            const modalBtn = event.target.closest(".modal-btn-video");

            const modalTitle = modalBtn.querySelector(".modal-title")?.innerHTML;
            const modalContent = modalBtn.querySelector(".modal-content")?.innerHTML;

            const siteModalTitle = document.querySelector("#siteModalVideo .modal-title");
            const siteModalBody = document.querySelector("#siteModalVideo .modal-body iframe");

            if (siteModalTitle) siteModalTitle.innerHTML = modalTitle;
            if (siteModalBody) siteModalBody.src = "https://www.youtube.com/embed/" + modalContent;

            siteModalVideo.show();
        }

    });
    const ModalVideo =document.getElementById("siteModalVideo");

    ModalVideo.addEventListener('hidden.bs.modal', function() {
        const siteModalIframe = document.querySelector("#siteModalVideo .modal-body iframe");
        siteModalIframe.src = "";
    });
</script>
<?php get_footer(); ?>