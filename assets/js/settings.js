(function($) {
  'use strict';
  $(function() {
    var $loader, $rentcafeDataContainer;
    $('#tabs').tabs();
    // Place your administration-specific JavaScript here
    $rentcafeDataContainer = $('#rentcafe-request-data');
    $loader = $('#loader');
    return $('.api_lookup_button').on('click', function(event) {
      var $method;
      event.preventDefault();
      $rentcafeDataContainer.empty();
      $method = $(this).data('method');
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          method: $method,
          action: 'get_rentcafe_data_ajax'
        },
        beforeSend: function() {
          return $loader.fadeIn();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          return console.log(jqXHR, textStatus, errorThrown);
        },
        success: function(data, textStatus, jqXHR) {
          var response;
          $loader.fadeOut();
          if (data.length) {
            response = JSON.parse(data);
            //						console.log(jqXHR)
            return $rentcafeDataContainer.append(response.data.body);
          } else {
            return $rentcafeDataContainer.append('no data');
          }
        }
      });
    });
  });
//					console.log(data, textStatus, jqXHR)
})(jQuery);

//# sourceMappingURL=settings.js.map
