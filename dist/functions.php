function consultorio_meta_callback($post)
{
    // Adiciona a folha de estilo e o script do Leaflet de forma adequada
    wp_enqueue_style('leaflet-style', 'https://npmcdn.com/leaflet@0.7.7/dist/leaflet.css');
    wp_enqueue_script('leaflet-script', 'https://npmcdn.com/leaflet@0.7.7/dist/leaflet.js', array('jquery'), '', true);

    $endereco = get_post_meta($post->ID, '_endereco', true);
    $email = get_post_meta($post->ID, '_email', true);
    $telefone = get_post_meta($post->ID, '_telefone', true);
    $latitude = get_post_meta($post->ID, '_latitude', true);
    $longitude = get_post_meta($post->ID, '_longitude', true);
    ?>
    <label for="endereco">
        <h3 style="margin:0">Endereço:</h3>
    </label>

    <?php
    $content = esc_textarea($endereco);
    $editor_id = 'endereco';
    wp_editor($content, $editor_id, array(
        'textarea_name' => 'endereco',
        'media_buttons' => false,
        'teeny' => true,
        'textarea_rows' => 5,
    ));
    ?>

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
            value="<?php echo esc_attr($email); ?>"
            required>
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
            value="<?php echo esc_attr($telefone); ?>"
            required>
        </div>
    </div>
    <hr style="margin-top: 15px">
    <label for="latitude"><h3>Localização:</h3></label>
    <input
    type="hidden"
    id="latitude"
    name="latitude"
    value="<?php if ($latitude) {
        echo esc_attr($latitude);
           } else {
               echo '-8.28307606871477';
           } ?>" required>

    <input
    type="hidden"
    id="longitude"
    name="longitude"
    value="<?php if ($longitude) {
        echo esc_attr($longitude);
           } else {
               echo '-35.96947431564331';
           } ?>" required>
    <div id="MapLocation" style="height: 350px"></div>

    <script>
        jQuery(document).ready(function($){
            var curLocation = [<?php echo esc_attr($latitude); ?>, <?php echo esc_attr($longitude); ?>];
            var map = L.map('MapLocation').setView(curLocation, 18);

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var marker = new L.marker(curLocation, { draggable: 'true' });

            marker.on('dragend', function(event) {
                var position = marker.getLatLng();
                marker.setLatLng(position).bindPopup(position).update();
                $('#latitude').val(position.lat);
                $('#longitude').val(position.lng);
            });

            map.addLayer(marker);
        });
    </script>
<?php
}
