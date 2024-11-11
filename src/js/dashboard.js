jQuery(document).ready(function ($) {
  $(".icon-search").on("input", function () {
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

  $(".selectable-icon").on("click", function () {
    var parentEl = $(this).closest(".icon-module");
    var preinput = parentEl.find(".preinput");
    preinput.val($(this).data("icon"));
    parentEl
      .find(".selectable-icon")
      .addClass("button-secondary")
      .removeClass("button-primary");
    $(this).removeClass("button-secondary").addClass("button-primary");
  });

  $(".changeicon").on("click", function () {
    var parentEl = $(this).closest(".icon-module");
    var iconbox = parentEl.find(".iconselectbox");
    iconbox.slideToggle(500);
    parentEl.toggleClass('opened');
    $(this).find('i').toggleClass('lni-chevron-down');
    $(this).find('i').toggleClass('lni-xmark');
  });

  $(".selecticonbutton").on("click", function () {
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
