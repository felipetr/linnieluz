<?php
function render_autocomplete_input(
    $inputid = '',
    $inputname = '',
    $inputvalue = ''
) {
    $json_directory_path = get_template_directory() . '/assets/json/';

    $icons_data = [];

    $json_files = glob($json_directory_path . '*.json');

    foreach ($json_files as $json_file) {
        // Lê o conteúdo de cada arquivo JSON
        $json_content = file_get_contents($json_file);

        // Decodifica o conteúdo JSON para um array
        $json_data = json_decode($json_content, true);

        // Verifica se a key 'icons' existe e se é um array
        if (isset($json_data['icons']) && is_array($json_data['icons'])) {
            // Concatena os ícones ao array principal
            $icons_data = array_merge($icons_data, $json_data['icons']);
        }
    }

    usort($icons_data, function ($a, $b) {
        return strcmp($a['name'], $b['name']);
    });
    ?>

    <div class="icon-module">
        <div class="icon-box">
            <div class="iconshow">
                <i class="<?php
                            echo !empty($inputvalue) ? $inputvalue : 'lni lni-question-mark';
                ?>"></i>
            </div>
            <button type="button" class="changeicon">
                <span><?php echo !empty($inputvalue) ? 'Alterar' : 'Adicionar'; ?> Ícone</span>
                <i class="lni lni-chevron-down"></i>
            </button>
        </div>
        <?php

        $json_directory_path = get_template_directory() . '/assets/json/';
        $icons_list = [];
        $json_files = glob($json_directory_path . '*.json');

        foreach ($json_files as $json_file) {
            $json_content = file_get_contents($json_file);
            $json_data = json_decode($json_content, true);

            if (isset($json_data['icons']) && is_array($json_data['icons'])) {
                $icons_list = array_merge($icons_list, $json_data['icons']);
            }
        }

        usort($icons_list, function ($a, $b) {
            return strcmp($a['name'], $b['name']);
        });



        ?>

        <div class="iconselectbox" style="display: none;">
            <input type="hidden" class="preinput" />
            <input type="hidden"
            value="<?php echo $inputvalue; ?>"
            name="<?php echo $inputname; ?>"
            id="<?php echo $inputid; ?>"
            class="icon-input" />
            <input type="text" placeholder="Filtrar..." class="icon-search">

            <hr>
            <div>
                <?php


                foreach ($icons_list as $key => $icon) {
                    $keywords = preg_replace(
                        '/\s+/',
                        ' ',
                        strtolower(
                            iconv(
                                'UTF-8',
                                'ASCII//TRANSLIT',
                                str_replace(
                                    '-',
                                    ' ',
                                    $icon['name']
                                ) . ' ' . $icon['keywords']
                            )
                        )
                    );
                    ?>
                    <button style="<?php if ($key > 5) {
                                        echo 'display:none;';
                                   } ?>"
                    type="button"
                    class="icon-button selectable-icon button-secondary"
                    data-icon="<?php echo $icon['class'] . $icon['name']; ?>"
                    data-keywords="<?php  echo trim($keywords);?>">
                        <i class="<?php echo $icon['class'] . $icon['name']; ?>"></i>
                        <span style="font-size: 10px; line-height: 10px; display:block;"></span>
                    </button>
                    <?php
                }
                ?>
                <button type="button" class="icon-button button-secondary" disabled>
                    <i>...</i>
                </button>
            </div>
            <hr>
            <div class="text-end">
                <button type="button" class="selecticonbutton button button-primary button-large">Selecionar</button>
            </div>
        </div>
    </div>
    <?php
}
?>
