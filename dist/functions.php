<?php

class Destaques_Walker_Nav_Menu extends Walker_Nav_Menu
{
    private $is_first_item = true;
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
    {
        $title = esc_html($item->title);
        $link = esc_url($item->url);

        // Marcar o primeiro item como "active"
        $active_class = $this->is_first_item ? 'active' : '';
        $this->is_first_item = false; // Marcar que o primeiro item já foi processado

        // Gerar a estrutura HTML de cada item
        $output .= '
            <div class="carousel-item ' . $active_class . '">
                <div class="destaquebox">
                    <div class="destaqueitens">
                        <h3>' . $title . '</h3>
                        <a href="' . $link . '" title="Saiba Mais" class="destaque_btn mt-3">Saiba Mais</a>
                    </div>
                </div>
            </div>';
    }
}

function remove_posts_col($columns)
{
    unset($columns['author']);
    unset($columns['tags']);
    unset($columns['categories']);
    return $columns;
}
function remove_pages_col($columns)
{
    unset($columns['author']);
    unset($columns['comments']);
    return $columns;
}
add_filter('manage_posts_columns', 'remove_posts_col');
add_filter('manage_pages_columns', 'remove_pages_col');

function posttag($title, $resume, $link, $image, $post = true)
{
?>
    <div class="postarchive p-relative">
        <div class="row">
            <div class="col-12 col-lg-4">
                <figure class="postarchive-figure">
                    <img class="d-none d-md-block"
                        style="background-image: url(<?php echo esc_url($image); ?>);"
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/postarchive.svg"
                        title="<?php echo esc_attr($title); ?>" alt="<?php echo esc_attr($title); ?>">
                    <img class="d-block d-md-none"
                        style="background-image: url(<?php echo esc_url($image); ?>);"
                        src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/postarchive.svg"
                        title="<?php echo esc_attr($title); ?>" alt="<?php echo esc_attr($title); ?>">
                </figure>
            </div>
            <div class="col-12 col-lg-8">
                <div class="p-4">
                    <h3 class="postarchivetitle text-center text-lg-start"><?php echo esc_html($title); ?></h3>
                    <div class="postarticleresume d-none d-xl-block">
                        <small>
                            <?php
                           if (strlen($resume) > 300) {
                            $resume = substr($resume, 0, 300) . "...";
                        }
                            
                            echo nl2br($resume); ?>
                        </small>

                    </div>
                    <a class="green-rounded-btn d-block d-lg-none" href="<?php echo esc_url($link); ?>">
                        <?php if ($post) {
                            echo 'Ler Artigo';
                        } else {
                            echo "Saiba Mais";
                        }
                        ?></a>
                    <div class="d-none d-lg-block">
                        <div class="row buttonrow">
                            <div class="col-12 col-md-8"></div>
                            <div class="col-12 col-md-4">
                                <div class="p-4">
                                    <a class="green-rounded-btn" href="<?php echo esc_url($link); ?>">
                                        <?php if ($post) {
                                            echo 'Ler Artigo';
                                        } else {
                                            echo "Saiba Mais";
                                        }
                                        ?></a>
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
function add_thumbnail_support_to_all_post_types()
{
    $post_types = get_post_types(array('public' => true), 'names');
    foreach ($post_types as $post_type) {
        add_post_type_support($post_type, 'thumbnail');
    }
}
add_action('init', 'add_thumbnail_support_to_all_post_types');

register_nav_menus(['primary' => 'Menu Principal']);
register_nav_menus(['destaques' => 'Destaques']);

function add_contact_tab_to_dashboard()
{
    add_submenu_page(
        'options-general.php',
        'Dados de Contato',
        'Dados de Contato',
        'manage_options',
        'contact_settings',
        'render_contact_settings_page'
    );
}
add_action('admin_menu', 'add_contact_tab_to_dashboard');

function render_contact_settings_page()
{
    $email = get_option('contact_email', '');
    $telefone = get_option('contact_telefone', '');
    $redes_sociais = get_option('contact_redes_sociais', array());
    $youtubeid = get_option('contact_youtube_id');
    $formtag = get_option('contact_form_tag');
    $formtag = str_replace("\\", "", $formtag);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        update_option('contact_email', sanitize_email($_POST['contact_email']));
        update_option('contact_telefone', sanitize_text_field($_POST['contact_telefone']));
        update_option('contact_form_tag', sanitize_text_field($_POST['contact_form_tag']));
        update_option('contact_youtube_id', sanitize_text_field($_POST['contact_youtube_id']));
        $redes_sociais = array();
        if (isset($_POST['rede_nome']) && is_array($_POST['rede_nome'])) {
            foreach ($_POST['rede_nome'] as $index => $nome) {
                $redes_sociais[] = array(
                    'nome' => sanitize_text_field($nome),
                    'link' => esc_url($_POST['rede_link'][$index]),
                    'icone' => sanitize_text_field($_POST['rede_icone'][$index]),
                    'arroba' => sanitize_text_field($_POST['rede_arroba'][$index])
                );
            }
        }
        update_option('contact_redes_sociais', $redes_sociais);

        echo '<div class="updated"><p>Configurações salvas.</p></div>';
    }

?>
    <div class="wrap">
        <h1>Dados de Contato</h1>
        <form method="POST">
            <table class="form-table">
                <tr>
                    <th><label for="contact_email">Email</label></th>
                    <td>
                        <input
                            type="email"
                            id="contact_email"
                            name="contact_email"
                            value="<?php echo esc_attr($email); ?>"
                            class="regular-text"
                            required>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label
                            for="contact_telefone">Telefone/Whatsapp<br>
                            <small>Apenas números e com DDD<br>Formato:81999999999</small>
                        </label>
                    </th>
                    <td>
                        <input
                            type="text"
                            id="contact_telefone"
                            name="contact_telefone"
                            value="<?php echo esc_attr($telefone); ?>"
                            class="regular-text"
                            required>
                    </td>
                </tr>
                <?php
                $current_user = wp_get_current_user();
                $user_login = $current_user->user_login; ?>
                <tr style="<?php if ($user_login != 'webmaster') {
                                echo 'display: none;';
                            } ?>">
                    <th><label for="contact_form_tag">Id do Formulário<br>Instale o Contact 7</label>
                    </th>
                    <td>
                        <input
                            type="text"
                            id="contact_form_tag"
                            name="contact_form_tag"
                            value="<?php echo esc_attr($formtag); ?>"
                            class="regular-text"
                            required>
                    </td>
                </tr>
                <tr style="<?php if ($user_login != 'webmaster') {
                                echo 'display: none;';
                            } ?>">
                    <th><label for="contact_youtube_id">ID do Canal do Youtube</label></th>
                    <td>
                        <input
                            type="text"
                            id="contact_youtube_id"
                            name="contact_youtube_id"
                            value="<?php echo esc_attr($youtubeid); ?>"
                            class="regular-text"
                            required>
                    </td>
                </tr>
                <tr>
                    <th>Redes Sociais</th>
                    <td>
                        <div id="redes_sociais">
                            <?php if (!empty($redes_sociais)) {
                                foreach ($redes_sociais as $rede) { ?>
                                    <div class="socialmediabox">
                                        <button type="button" class="socialmedia-title">
                                            <span class="title-rede"><?php echo esc_attr($rede['nome']); ?></span>
                                            <?php
                                            if ($rede['icone'] == 'lni lni-question-mark') { ?>
                                                <span class="select-icon">
                                                    <span
                                                        class="bi bi-exclamation-diamond-fill">
                                                    </span> Selecione um ícone</span>
                                            <?php }
                                            ?><i class="lni lni-chevron-down"></i></button>
                                        <div class="socialmedia-container" style="display: none;">
                                            <label>Ícone:</label>
                                            <?php
                                            $iconid = uniqid(sanitize_title($rede['icone']), true);
                                            render_autocomplete_input(
                                                $iconid,
                                                'rede_icone[]',
                                                $rede['icone']
                                            ); ?>
                                            <label>Nome:</label>
                                            <input
                                                type="text"
                                                class="rede-name"
                                                name="rede_nome[]"
                                                value="<?php echo esc_attr($rede['nome']); ?>"
                                                placeholder="Nome"
                                                required>
                                            <label>URL:</label>
                                            <input
                                                type="url"
                                                name="rede_link[]"
                                                value="<?php echo esc_attr($rede['link']); ?>"
                                                placeholder="Link"
                                                required>
                                            <label>Arroba:</label>
                                            <input
                                                type="text"
                                                name="rede_arroba[]"
                                                value="<?php echo esc_attr($rede['arroba']); ?>"
                                                placeholder="Arroba"
                                                required>

                                            <hr>
                                            <div class="text-end delete-socialmediabox">
                                                <button type="button" class="button-primary delete-socialmedia">
                                                    <i class="lni lni-trash-3"></i> Excluir
                                                </button>
                                            </div>
                                            <div class="text-end confirm-delete-socialmediabox" style="display:none">
                                                <b>Confirma a Exclusão?</b>
                                                <button type="button" class="button-primary confirm-delete-socialmedia">
                                                    Excluir
                                                </button>
                                                <button type="button" class="button-secondary delete-socialmedia">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <hr>
                        <div>
                            <button
                                type="button"
                                class="button-secondary"
                                id="new-socialmedia">
                                <i class="lni lni-plus"></i>
                                Adicionar Rede Social
                            </button>
                        </div>
                        <hr>
                        <div class="text-end">
                            <input id="submitbtn" type="submit" class="button-primary" value="Salvar Configurações">
                        </div>
                    </td>
                </tr>
            </table>

        </form>
    </div>
<?php
}

function load_dash_head()
{
?>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/dashboard.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/lib/linnieluzicons/linnieluzicons.css">
    <link rel="stylesheet" href="https://cdn.lineicons.com/5.0/lineicons.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<?php
}
add_action('admin_head', 'load_dash_head');
function load_dash_footer()
{
?>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/js/dashboard.min.js"></script>
<?php
}
add_action('admin_footer', 'load_dash_footer');

function register_custom_post_types()
{
    // Consultórios
    register_post_type('consultorio', array(
        'labels' => array(
            'name' => 'Consultórios',
            'singular_name' => 'Consultório',
            'add_new' => 'Adicionar novo consultório',
            'add_new_item' => 'Adicionar novo consultório',
            'edit_item' => 'Editar consultório',
            'new_item' => 'Novo consultório',
            'view_item' => 'Ver consultório',
            'search_items' => 'Pesquisar consultórios',
            'not_found' => 'Nenhum consultório encontrado',
            'not_found_in_trash' => 'Nenhum consultório encontrado na lixeira'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'menu_icon' => 'dashicons-building',
    ));

    // Perguntas Frequentes
    register_post_type('pergunta', array(
        'labels' => array(
            'name' => 'Perguntas Frequentes',
            'singular_name' => 'Pergunta',
            'add_new' => 'Adicionar nova pergunta',
            'add_new_item' => 'Adicionar nova pergunta',
            'edit_item' => 'Editar pergunta',
            'new_item' => 'Nova pergunta',
            'view_item' => 'Ver pergunta',
            'search_items' => 'Pesquisar perguntas',
            'not_found' => 'Nenhuma pergunta encontrada',
            'not_found_in_trash' => 'Nenhuma pergunta encontrada na lixeira'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-format-chat',
    ));

    // Áreas de Atuação
    register_post_type('area_de_atuacao', array(
        'labels' => array(
            'name' => 'Áreas de Atuação',
            'singular_name' => 'Área de Atuação',
            'add_new' => 'Adicionar nova área de atuação',
            'add_new_item' => 'Adicionar nova área de atuação',
            'edit_item' => 'Editar área de atuação',
            'new_item' => 'Nova área de atuação',
            'view_item' => 'Ver área de atuação',
            'search_items' => 'Pesquisar áreas de atuação',
            'not_found' => 'Nenhuma área de atuação encontrada',
            'not_found_in_trash' => 'Nenhuma área de atuação encontrada na lixeira'
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor'),
        'menu_icon' => 'dashicons-businessman',
    ));
}
add_action('init', 'register_custom_post_types');
function add_custom_meta_boxes()
{
    // Meta box para Consultório
    add_meta_box(
        'consultorio_meta',
        'Informações do Consultório',
        'consultorio_meta_callback',
        'consultorio',
        'normal',
        'high'
    );
    // Meta box para Área de Atuação
    add_meta_box(
        'area_meta',
        'Informações da Área de Atuação',
        'area_meta_callback',
        'area_de_atuacao',
        'normal',
        'high'
    );
}

function consultorio_meta_callback($post)
{
    // Recuperar dados armazenados
    $endereco = get_post_meta($post->ID, '_endereco', true);
    $email = get_post_meta($post->ID, '_email', true);
    $telefone = get_post_meta($post->ID, '_telefone', true);
    $latitude = get_post_meta($post->ID, '_latitude', true);
    $longitude = get_post_meta($post->ID, '_longitude', true);
    $thumbnail = get_post_meta($post->ID, '_thumbnail', true);
    $video = get_post_meta($post->ID, '_video', true);
?>
    <label for="endereco">
        <h3 style="margin:0">Imagem:</h3>
    </label>
    <?php
    // Função para enfileirar o script da biblioteca de mídia
    function my_enqueue_media_script()
    {
        wp_enqueue_media();
    }
    add_action('admin_enqueue_scripts', 'my_enqueue_media_script');
    ?>

    <!-- HTML do campo de upload de mídia -->
    <div>
        <input
            type="hidden"
            id="media-url"
            name="thumbnail"
            value="<?php echo isset($thumbnail) ? esc_attr($thumbnail) : ''; ?>"
            readonly />
        <img id="consultorio-cover" title="Capa" alt="Capa" src="<?php
                                                                    if ($thumbnail) {
                                                                        echo esc_attr($thumbnail);
                                                                    } else {
                                                                        echo get_template_directory_uri() . '/assets/images/consultorio.svg';
                                                                    }
                                                                    ?>">
        <div><button type="button" id="media-upload-button" class="button-primary">Selecionar</button>
        </div>
    </div>
    <hr style="margin-top: 15px">



    <div class="metabox-content">
        <div class="form-field form-required">
            <label for="email">
                <h3>Email:</h3>
            </label>
            <input
                type="email"
                id="email"
                class="widefat"
                placeholder="Preencha o Email"
                name="email"
                value="<?php echo esc_attr($email); ?>">
        </div>
        <div class="form-field form-required">
            <label for="telefone">
                <h3>Telefone:</h3>
            </label>
            <input
                type="text"
                id="telefone"
                class="widefat"
                name="telefone"
                value="<?php echo esc_attr($telefone); ?>">
        </div>
    </div>
    <label for="video">
        <h3>Vídeo:<br>
            <small>Formato: https://www.youtube.com/watch?v=VideoID</small>
        </h3>
    </label>
    <div class="formline">


        <input
            type="search"
            id="video"
            class="widefat videoinput"
            name="video"
            value="<?php echo esc_attr($video); ?>">
        <button type="button" class="button-primary viewvideo">Verificar</button>


    </div>

    <?php
    $hasVideo = true;
    if (!$video) {
        $hasVideo = false;
        $video = 'https://www.youtube.com/watch?v=wjQq0nSGS28';
    }
    $videoID = explode('v=', $video)[1];

    ?>
    <div class="videobox" <?php if (!$hasVideo) {
                                echo 'style="display: none;"';
                            } ?>>
        <hr>
        <div class="preratio">
            <div class="ratio-16x9">
                <iframe
                    src="<?php if ($hasVideo) {
                                echo "https://www.youtube.com/embed/" . $videoID;
                            } ?>"
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

    <hr style="margin-top: 15px">
    <label for="endereco">
        <h3 style="margin:0">Endereço:</h3>
    </label>

    <?php
    $content = esc_textarea($endereco);
    $editor_id = 'endereco';
    ?>
    <textarea rows="5" class="widefat" name="endereco" id="endereco"><?php echo $content; ?></textarea>
    <hr style="margin-top: 15px">
    <label for="latitude">
        <h3>Localização:</h3>
    </label>
    <input
        type="hidden"
        id="latitude"
        name="latitude"
        value="<?php if ($latitude) {
                    echo esc_attr($latitude);
                } else {
                    echo '-8.28307606871477';
                } ?>"
        required>


    <input
        type="hidden"
        id="longitude"
        name="longitude"
        value="<?php if ($longitude) {
                    echo esc_attr($longitude);
                } else {
                    echo '-35.96947431564331';
                } ?>" required>
    <link rel="stylesheet" href="https://npmcdn.com/leaflet@0.7.7/dist/leaflet.css">

    <div id="MapLocation" style="height: 350px">




        <script id="rendered-js">
            $(function() {
                $(".viewvideo").click(function() {
                    var videoUrl = $('.videoinput').val();
                    if (videoUrl) {
                        var videoID = videoUrl.split('v=')[1];
                        $('.videoIframe').attr('src', "https://www.youtube.com/embed/" + videoID);
                        $('.videobox').slideDown(500);
                    } else {
                        $('.videobox').slideUp(500);
                        $('.videoIframe').attr('src', "");
                    }

                });

                var curLocation = [0, 0];

                if (curLocation[0] == 0 && curLocation[1] == 0) {
                    curLocation = [-8.28307606871477, -35.96947431564331];
                }

                var map = L.map('MapLocation').setView(curLocation, 18);

                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
                }).
                addTo(map);

                map.attributionControl.setPrefix(false);

                var marker = new L.marker(curLocation, {
                    draggable: 'true'
                });


                marker.on('dragend', function(event) {
                    var position = marker.getLatLng();
                    marker.setLatLng(position, {
                        draggable: 'true'
                    }).
                    bindPopup(position).update();
                    $("#latitude").val(position.lat);
                    $("#longitude").val(position.lng).keyup();
                });

                $("#latitude, #longitude").change(function() {
                    var position = [parseInt($("#latitude").val()), parseInt($("#longitude").val())];
                    marker.setLatLng(position, {
                        draggable: 'true'
                    }).
                    bindPopup(position).update();
                    map.panTo(position);
                });

                map.addLayer(marker);
            });
        </script>


    <?php
}
require_once get_template_directory() . '/functions/autocomplete-input.php';
function area_meta_callback($post)
{
    $icone = get_post_meta($post->ID, '_icone', true);
    ?>
        <label for="icone">Ícone:</label>
    <?php
    render_autocomplete_input(
        'icone',
        'icone',
        esc_attr($icone)
    );
}




function save_custom_meta_boxes($post_id)
{
    // Salvar dados do Consultório
    if (array_key_exists('endereco', $_POST)) {
        update_post_meta($post_id, '_endereco', sanitize_textarea_field($_POST['endereco']));
    }
    if (array_key_exists('email', $_POST)) {
        update_post_meta($post_id, '_email', sanitize_email($_POST['email']));
    }
    if (array_key_exists('telefone', $_POST)) {
        update_post_meta($post_id, '_telefone', sanitize_text_field($_POST['telefone']));
    }
    if (array_key_exists('latitude', $_POST)) {
        update_post_meta($post_id, '_latitude', sanitize_text_field($_POST['latitude']));
    }
    if (array_key_exists('longitude', $_POST)) {
        update_post_meta($post_id, '_longitude', sanitize_text_field($_POST['longitude']));
    }
    if (array_key_exists('thumbnail', $_POST)) {
        update_post_meta($post_id, '_thumbnail', sanitize_text_field($_POST['thumbnail']));
    }
    if (array_key_exists('video', $_POST)) {
        update_post_meta($post_id, '_video', sanitize_text_field($_POST['video']));
    }

    // Salvar dados da Área de Atuação
    if (array_key_exists('icone', $_POST)) {
        update_post_meta($post_id, '_icone', sanitize_text_field($_POST['icone']));
    }

    // Salvar dados de Contato
    if (array_key_exists('contato_email', $_POST)) {
        update_post_meta($post_id, '_contato_email', sanitize_email($_POST['contato_email']));
    }
    if (array_key_exists('contato_telefone', $_POST)) {
        update_post_meta($post_id, '_contato_telefone', sanitize_text_field($_POST['contato_telefone']));
    }
    if (array_key_exists('rede_nome', $_POST)) {
        $redes_sociais = [];
        foreach ($_POST['rede_nome'] as $index => $nome) {
            if (!empty($nome)) {
                $redes_sociais[] = [
                    'nome' => sanitize_text_field($nome),
                    'link' => sanitize_text_field($_POST['rede_link'][$index]),
                    'icone' => sanitize_text_field($_POST['rede_icone'][$index]),
                    'arroba' => sanitize_text_field($_POST['rede_arroba'][$index])
                ];
            }
        }
        update_post_meta($post_id, '_redes_sociais', $redes_sociais);
    }

    // Salvar dados do Canal do YouTube
    if (array_key_exists('youtube_channel_id', $_POST)) {
        update_option('youtube_channel_id', sanitize_text_field($_POST['youtube_channel_id']));
    }
}

add_action('save_post', 'save_custom_meta_boxes');
add_action('add_meta_boxes', 'add_custom_meta_boxes');

function add_custom_destaque_meta_box()
{
    add_meta_box(
        'custom_destaque_meta_box',      // ID do Meta Box
        'Destaque',                      // Título do Meta Box
        'display_custom_destaque_meta_box', // Função de Callback
        'post',                          // Tipo de Post (aqui é para 'post', mas pode mudar)
        'side',                          // Localização do Meta Box
        'high'                           // Prioridade do Meta Box
    );
}
add_action('add_meta_boxes', 'add_custom_destaque_meta_box');

function display_custom_destaque_meta_box($post)
{
    // Recupera o valor atual do campo personalizado (se existir)
    $destaque = get_post_meta($post->ID, '_destaque_post', true);
    $destaque_image = get_post_meta($post->ID, '_destaque_image', true);

    // Adiciona um nonce para verificação de segurança
    wp_nonce_field(basename(__FILE__), 'custom_destaque_nonce');

    // Exibe o campo checkbox
    ?>
        <label for="destaque_post">
            <input
                type="checkbox"
                name="destaque_post"
                id="destaque_post"
                value="1"
                <?php checked($destaque, '1'); ?> />
            Marcar como destaque
        </label>
        <br><br>

        <label for="destaque_image">Imagem de Destaque:</label>
        <img id="capa" title="Capa" alt="Capa" src="<?php
                                                    if ($destaque_image) {
                                                        echo esc_attr($destaque_image);
                                                    } else {
                                                        echo get_template_directory_uri() . '/assets/images/news.svg';
                                                    }
                                                    ?>">
        <input
            type="hidden"
            name="destaque_image"
            id="destaque_image"
            value="<?php echo esc_url($destaque_image); ?>"
            style="width: 100%;" />
        <button type="button" class="button upload_image_button">Selecionar Imagem</button>

        <script>
            jQuery(document).ready(function($) {
                var mediaUploader;
                $('.upload_image_button').click(function(e) {
                    e.preventDefault();
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                    mediaUploader = wp.media({
                        title: 'Selecionar Imagem de Destaque',
                        button: {
                            text: 'Usar esta imagem'
                        },
                        multiple: false
                    });
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        $('#destaque_image').val(attachment.url);
                        $("#capa").attr("src", attachment.url);
                    });
                    mediaUploader.open();
                });
            });
        </script>
    <?php
}

function save_custom_destaque_meta_box($post_id)
{
    // Verifica o nonce para garantir a segurança
    if (
        !isset($_POST['custom_destaque_nonce'])
        ||
        !wp_verify_nonce($_POST['custom_destaque_nonce'], basename(__FILE__))
    ) {
        return $post_id;
    }

    // Verifica se o usuário tem permissão para editar o post
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    // Salva o valor do checkbox
    $destaque = isset($_POST['destaque_post']) ? '1' : '';
    update_post_meta($post_id, '_destaque_post', $destaque);

    // Salva o valor do campo de imagem
    if (isset($_POST['destaque_image'])) {
        update_post_meta($post_id, '_destaque_image', esc_url_raw($_POST['destaque_image']));
    }
}
add_action('save_post', 'save_custom_destaque_meta_box');
