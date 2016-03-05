$(document).ready(function() {
  initSearch();
  reorderPanels();
});

$(window).on('resize orientationChange', function(event) {
  reorderPanels();
});

// Function to make a masonry grid layout
function reorderPanels() {
  $('.grid').masonry({
    itemSelector: '.grid-item'
  });
}
