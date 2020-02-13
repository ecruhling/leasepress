(function($) {
  'use strict';
  $(function() {
    $('#tabs').tabs();
    // Place your administration-specific JavaScript here
    return $('#lp_api_floorplans_lookup_submit').on('click', function(event) {
      event.preventDefault();
      console.log('works');
      $.ajax({
        url: ajaxurl,
        data: {
          action: 'get_data'
        },
        error: function(jqXHR, textStatus, errorThrown) {
          return console.log(jqXHR, textStatus, errorThrown);
        },
        success: function(data, textStatus, jqXHR) {
          return console.log(data, textStatus, jqXHR);
        }
      });
    });
  });
})(jQuery);

//# sourceMappingURL=settings.js.map
