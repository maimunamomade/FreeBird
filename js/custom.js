$(document).ready(function() {
  $('.notop').sticky({
    zIndex: 1000,
    className: 'stickytop'
  });

  $('.home-featured-carousel').owlCarousel({
    items: 4,
    margin: 30,
    stagePadding: 30,
    autoplay: true,
    autoplaySpeed: 1000,
    responsiveClass: true,
    responsive: {
      0: {
        items: 1
      },

      480: {
        items: 1
      },

      600: {
        items: 2
      },

      768: {
        items: 3
      },

      1000: {
        items: 4
      }
    }
  });

  $('[data-toggle="tooltip"]').tooltip();

  $(document).on('click', '.dropdown-menu', function(event) {
    event.stopPropagation();
  });

  $('.dropdown-menu .dropdown-item.dropdown-toggle').click(function() {
    $('.collapse.dropdown-submenu').collapse('hide');
  });

  $('.user-home-featured-carousel').owlCarousel({
    items: 3,
    margin: 30,
    stagePadding: 20,
    autoplay: true,
    autoplaySpeed: 1000,
    responsive: {
      0: {
        items: 1
      },

      480: {
        items: 1
      },

      600: {
        items: 2
      },

      1000: {
        items: 3
      }
    }
  });
});
