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
        data: {
          method: $method,
          action: 'get_data'
        },
        error: function(jqXHR, textStatus, errorThrown) {
          return console.log(jqXHR, textStatus, errorThrown);
        },
        success: function(data, textStatus, jqXHR) {
          var response;
          if (data.length) {
            response = JSON.parse(data);
            $('#rentcafe-request-data').append(response.data.body);
          } else {
            $('#rentcafe-request-data').append('no data');
          }
          console.log(data, textStatus, jqXHR);
          return console.log(JSON.parse(data));
        }
      });
    });
  });
})(jQuery);

//# sourceMappingURL=settings.js.map
