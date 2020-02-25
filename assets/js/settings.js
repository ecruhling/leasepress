(function($) {
  'use strict';
  $(function() {
    var $loader, $rentcafeDataContainer;
    $('#tabs').tabs();
    // Place your administration-specific JavaScript here
    $rentcafeDataContainer = $('#rentcafe-request-data');
    $loader = $('#loader');
    $('.api_lookup_button').on('click', function(event) {
      var $method;
      event.preventDefault();
      $rentcafeDataContainer.empty();
      $method = $(this).data('method');
      return $.ajax({
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
            $rentcafeDataContainer.append('<p><strong>RENTCafe URL Lookup:</strong> ' + response.data[0] + '</p>');
            return $rentcafeDataContainer.append('<p><strong>Data:</strong> ' + response.data[1].body);
          } else {
            return $rentcafeDataContainer.append('no data');
          }
        }
      });
    });
    return $('.api_clear_cache').on('click', function(event) {
      event.preventDefault();
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          action: 'delete_rentcafe_transient'
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
