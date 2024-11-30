<?php if (have_comments()) : ?>
  <h3>Comentários</h3>
  <ul class="comment-list">
    <?php wp_list_comments(); ?>
  </ul>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <?php previous_comments_link('&larr; Comentários Anteriores'); ?>
        <?php next_comments_link('Comentários Novos &rarr;'); ?>
    <?php endif; ?>

    <?php if (! comments_open()) : ?>
    <p>Comments are closed.</p>
    <?php endif; ?>

<?php endif; ?>


<?php
$args = array(
  'title_reply'          => 'Deixe seu comentário', // Título acima do formulário
  'label_submit'         => 'Enviar Comentário', // Texto do botão de envio
  'comment_field'        => '<p class="comment-form-comment">
                                 <label for="comment">Comentário <span class="text-danger">*</span></label>
                                 <textarea
                                 id="comment"
                                 class="form-control"
                                 name="comment"
                                 rows="5"
                                 required>
                                 </textarea>
                             </p>',
  'fields'               => array(
      'author' => '<p class="comment-form-author">
                      <label for="author">Nome <span class="text-danger">*</span></label>
                      <input id="author" name="author" type="text" value="" class="form-control" required />
                   </p>',
      'email'  => '<p class="comment-form-email">
                      <label for="email">Email <span class="text-danger">*</span></label>
                      <input id="email" name="email" type="email" value="" class="form-control" required />
                   </p>'
  ),
  'class_submit'         => 'btn btn-green',
  'class_form'           => 'custom-comment-form',
  'comment_notes_before' => '<p class="comment-notes">
  Seu email não será publicado. Campos obrigatórios estão marcados com <span class="text-danger">*</span>
  </p>',
  'comment_notes_after'  => '',
);


if (comments_open()) {
    comment_form($args);
}
?>