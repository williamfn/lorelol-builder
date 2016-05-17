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

function setMenu() {
  $('#dl-menu').dlmenu();
}

function bindLanguages(){
  $('.dl-submenu li:not(:first-child) a').click(function(){
    changeLanguage($(this).attr('id'));
  });
}
