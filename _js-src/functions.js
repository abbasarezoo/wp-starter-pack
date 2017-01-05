jQuery(document).ready(function ($) {

// =================================================
// BREAKPOINTS
// =================================================

var lg = 1200;
var md = 992;
var sm = 768;
var xs = 480;
var xxs = 400;

// =================================================
// RESPONSIVE DROPDOWNS
// =================================================

$(".toggle--secondary-nav").click(function(){
    $(".secondary-nav").toggle();
    if($(this).hasClass("open")){
      $(this).removeClass("open");
    }
    else {
      $(this).addClass("open");
    }
    return false;
});

// =================================================
// CLOSE MODAL WHEN CLICK OUTSIDE OF CONTAINER
// =================================================

$(document).mouseup(function (e) {
  var container = $(".article-filter");
  var toggle = $(".toggle--article-filter");

  if (!container.is(e.target) && container.has(e.target).length === 0 && !toggle.is(e.target) && toggle.has(e.target).length === 0)
  {
      container.hide();
      $(".toggle--article-filter").removeClass("open");
  }
});

// =================================================
// SLIDERS
// =================================================

$('.pd--gallery-slider').slick({
  infinite: true,
  slidesToShow: 1,
  slidesToScroll: 1,
  dots: false,
  focusOnSelect: true,
  arrows: false,
  accessibility: false,
  lazyLoad: 'ondemand'
});

$('.pd--gallery-slider-outer .slider-prev').click(function(){
    $('.pd--gallery-slider').slick('slickPrev');
    return false;
});

$('.pd--gallery-slider-outer .slider-next').click(function(){
    $('.pd--gallery-slider').slick('slickNext');
    return false;
});

// =================================================
// DISABLE SCROLL ZOOM ON GOOGLE MAPS
// =================================================

$('.map-embed').click(function () {
    $('.map-embed iframe').css("pointer-events", "auto");
});

$( ".map-embed" ).mouseleave(function() {
  $('.map-embed iframe').css("pointer-events", "none");
});

// =================================================
// SHOW FORM PLACEHOLDERS IN IE9
// =================================================

$('input, textarea').placeholder();

// =================================================
// DISABLE AUTO-COMPLETE FOR CF7
// =================================================

$('.wpcf7-form').attr('autocomplete', 'off').attr('autosuggest', 'off');


// =================================================
// END DOCUMENT READY
// =================================================
});