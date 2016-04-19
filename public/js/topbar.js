function setLanguageMenu() {
  var region = $('#region').val();
  var language = $('#language');
  var div = $('.language');

  language.val(region);
  language.on('change', function () {
    changeLanguage($(this).val());
  });

  div.css('display', 'block');
}

function changeLanguage(region) {
  $.ajax({
    type: "POST",
    url: "/ajax/changeLanguage",
    headers: { 'Lang': region },
    data: { region: region },
    dataType: 'json',
    success: function() {
      location.reload();
    },
  });
}
