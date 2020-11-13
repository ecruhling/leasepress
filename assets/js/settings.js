(function($) {
  'use strict';
  $(function() {
    var $cacheLoader, $dataLoader, $rentcafeDataContainer, $rightColumn;
    $('#tabs').tabs();
    // Place your administration-specific JavaScript here
    $rentcafeDataContainer = $('#rentcafe-request-data');
    $rightColumn = $('#right-column');
    $dataLoader = $('#data-loader');
    $cacheLoader = $('#cache-loader');
    $('.api_lookup_button').on('click', function(event) {
      var $method, $nonce, $type;
      event.preventDefault();
      $rentcafeDataContainer.empty();
      $method = $(this).data('method');
      $type = $(this).data('type');
      if ($type) {
        $nonce = $('#lp_api_' + $method + '_' + $type + '_lookup_nonce').attr('value');
      } else {
        $nonce = $('#lp_api_' + $method + '_lookup_nonce').attr('value');
      }
      return $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          method: $method,
          type: $type,
          action: 'get_rentcafe_data_ajax',
          nonce: $nonce
        },
        beforeSend: function() {
          $('html, body').animate({
            scrollTop: $rightColumn.offset().top - 30
          }, 500);
          return $dataLoader.fadeIn();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          return console.log(jqXHR, textStatus, errorThrown);
        },
        success: function(data, textStatus, jqXHR) {
          var response;
          $dataLoader.fadeOut();
          if (data.length) {
            response = JSON.parse(data);
            $rentcafeDataContainer.append('<p><strong>RENTCafe URL Lookup:</strong> <a href="' + response.data[0] + '" target="_blank" rel="noopener">' + response.data[0] + '</a></p>');
            return $rentcafeDataContainer.append('<p><strong>Data:</strong> ' + response.data[1].body);
          } else {
            return $rentcafeDataContainer.append('no data');
          }
        }
      });
    });
    $('.api_clear_cache').on('click', function(event) {
      event.preventDefault();
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          action: 'delete_rentcafe_transient'
        },
        beforeSend: function() {
          $('.api_clear_cache').addClass('disabled');
          return $cacheLoader.fadeIn();
        },
        error: function(jqXHR, textStatus, errorThrown) {},
        success: function(data, textStatus, jqXHR) {
          $('.api_clear_cache').removeClass('disabled');
          $cacheLoader.fadeOut();
          $('p.clear-cached-data').append('<strong class="cache-cleared-message">&nbsp;Cache Cleared and Resaved!</strong>');
          return $('.cache-cleared-message').delay(3000).fadeOut('normal', function() {
            return $(this).remove();
          });
        }
      });
    });
    return $('#save-button').on('click', function(event) {
      var $codeOrId, $propertyCode, $propertyId;
      $propertyCode = $('#lp_rentcafe_property_code').val();
      $propertyId = $('#lp_rentcafe_property_id').val();
      $codeOrId = $('#lp_rentcafe_code_or_id').val();
      if ($codeOrId === 'property_code' && !$propertyCode || $codeOrId === 'property_id' && !$propertyId) {
        event.preventDefault();
        return $('.cmb-form').append('<strong class="invalid-code-id">&nbsp;&nbsp;&nbsp;A valid Property Code OR Property ID must be used!</strong>');
      } else {
        return $('.invalid-code-id').remove();
      }
    });
  });
})(jQuery);

//# sourceMappingURL=settings.js.map
