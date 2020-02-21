(function($) {
  'use strict';
  $(function() {
    $('#tabs').tabs();
    // Place your administration-specific JavaScript here
    return $('.api_lookup_button').on('click', function(event) {
      var $method;
      event.preventDefault();
      $method = $(this).data('method');
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        async: true,
        data: {
          method: $method,
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
