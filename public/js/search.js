function initSearch() {
  var region = $('#region').val();
  $.ajax({
    url: "/json/champions-"+region+".json",
    dataType: "json",
    success: function(data) {
      var champion_data = $.map(data, function(item) {
        return {
          label: item.label,
          value: item.value,
        };
      });
      $("#search").autocomplete({
        delay: 200,
        source: champion_data,
        minLength: 2,
        select: function (event, ui) {
          window.location = '/champion/'+ui.item.value;
          event.preventDefault();
        },
        maxHeight: 300
      });
    }
  });
}
