jQuery(document).ready(function ($) {

  $("#media-url").change(function(e) {
    var value = $(this).val(); 
    $("#consultorio-cover").attr('src', value);
});

            $('#media-upload-button').click(function(e) {
                e.preventDefault();

                // Cria o frame de seleção de mídia
                var mediaFrame = wp.media({
                    title: 'Selecionar ou Fazer Upload de Mídia',
                    button: {
                        text: 'Usar esta mídia'
                    },
                    multiple: false
                });

                mediaFrame.on('select', function() {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    $('#media-url').val(attachment.url);
                    $("#consultorio-cover").attr("src", attachment.url);
                });

                mediaFrame.open();
            });

  // Delegação de evento para .socialmedia-title (funciona também para elementos criados dinamicamente)
  $("#redes_sociais").on("click", ".socialmedia-title", function () {
    var parentEl = $(this).closest(".socialmediabox");
    var iconbox = parentEl.find(".socialmedia-container");
    iconbox.slideToggle(500);
    parentEl.toggleClass("opened");
    $(this).find("i").toggleClass("lni-chevron-down");
    $(this).find("i").toggleClass("lni-xmark");
  });

  // Delegação de evento para .confirm-delete-socialmedia (funciona também para elementos criados dinamicamente)
  $("#redes_sociais").on("click", ".confirm-delete-socialmedia", function () {
    var parentEl = $(this).closest(".socialmediabox");
    parentEl.slideUp(500, function () {
      parentEl.remove();
      $('#submitbtn').click();
    });
    
  });

  // Delegação de evento para .delete-socialmedia (funciona também para elementos criados dinamicamente)
  $("#redes_sociais").on("click", ".delete-socialmedia", function () {
    var parentEl = $(this).closest(".socialmedia-container");
    var socialmediabox = parentEl.find(".delete-socialmediabox");
    var socialmediaboxconfirm = parentEl.find(".confirm-delete-socialmediabox");
    socialmediabox.slideToggle(500);
    socialmediaboxconfirm.slideToggle(500);
  });
  $(document).on("blur", ".rede-name", function () {
    var parentEl = $(this).closest(".socialmediabox");
    var titlename = parentEl.find(".title-rede");
    titlename.html($(this).val());
  });
  $(document).on("input", ".icon-search", function () {
    var inputValue = $(this).val();
    inputValue = inputValue
      .toLowerCase()
      .normalize("NFD")
      .replace(/[\u0300-\u036f]/g, "")
      .trim()
      .replace(/\s+/g, " ");
    var parentEl = $(this).closest(".icon-module");
    var iconbuttons = parentEl.find(".selectable-icon");
    var count = 0;

    iconbuttons.each(function () {
      $(this).hide();
      var dataKeywords = $(this).data("keywords");
      if (dataKeywords.includes(inputValue) && count < 8) {
        $(this).show();
        count++;
      }
    });
  });

  // Delegando evento de clique para .selectable-icon
  $(document).on("click", ".selectable-icon", function () {
    var parentEl = $(this).closest(".icon-module");
    var preinput = parentEl.find(".preinput");
    preinput.val($(this).data("icon"));
    parentEl
      .find(".selectable-icon")
      .addClass("button-secondary")
      .removeClass("button-primary");
    $(this).removeClass("button-secondary").addClass("button-primary");
  });

  // Delegando evento de clique para .changeicon
  $(document).on("click", ".changeicon", function () {
    var parentEl = $(this).closest(".icon-module");
    var iconbox = parentEl.find(".iconselectbox");
    iconbox.slideToggle(500);
    parentEl.toggleClass("opened");
    $(this).find("i").toggleClass("lni-chevron-down");
    $(this).find("i").toggleClass("lni-xmark");
  });

  $("#new-socialmedia").on("click", function () {
    var div = $("<div>", {
      class: "socialmediabox opened",
      css: {
        display: "none",
      },
    }).html(
      '<button type="button" class="socialmedia-title">' +
        '<span class="title-rede">Nova Rede Social</span><i class="lni lni-xmark"></i>' +
        "</button>" +
        '<div class="socialmedia-container">' +
        '<input type="hidden" name="rede_icone[]" value="lni lni-question-mark" required>' +
        '<label>Nome:</label><input class="rede-name" type="text" name="rede_nome[]" placeholder="Nome" required>' +
        '<label>URL:</label><input type="url" name="rede_link[]" placeholder="Link" required>' +
        '<div class="alert alert-warning"><i class="bi bi-exclamation-diamond-fill"></i> Salve para selecionar o ícone da rede social</div>' +
        "<hr>" +
        '<div class="text-end delete-socialmediabox"><button type="button" class="button-primary delete-socialmedia">' +
        '<i class="lni lni-trash-3"></i> Excluir</button></div>' +
        '<div class="text-end confirm-delete-socialmediabox" style="display:none">' +
        "<b>Confirma a Exclusão?</b>" +
        '<button type="button" class="button-primary confirm-delete-socialmedia">' +
        "Excluir" +
        "</button>" +
        '<button type="button" class="button-secondary delete-socialmedia">' +
        "Cancelar" +
        "</button>" +
        "</div>" +
        "</div>"
    );

    $("#redes_sociais").append(div);
    div.slideDown(500);
  });

  $(document).on("click", ".selecticonbutton", function () {
    var parentEl = $(this).closest(".icon-module");
    var iconinput = parentEl.find(".icon-input");
    var preinput = parentEl.find(".preinput");
    var iconshow = parentEl.find(".iconshow i");

    if (preinput.val()) {
      iconshow.removeClass().addClass(preinput.val());
      iconinput.val(preinput.val());
      parentEl.find(".changeicon").click();
    }
  });
});
