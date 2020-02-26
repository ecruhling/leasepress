(($) ->
	'use strict'
	$ ->
		$('#tabs').tabs()
		# Place your administration-specific JavaScript here
		$rentcafeDataContainer = $('#rentcafe-request-data')
		$rightColumn = $('#right-column')
		$dataLoader = $('#data-loader')
		$cacheLoader = $('#cache-loader')
		$('.api_lookup_button').on 'click', (event) ->
			(event).preventDefault()
			$rentcafeDataContainer.empty()
			$method = $(this).data('method')
			$type = $(this).data('type')
			$.ajax
				url: ajaxurl
				type: 'POST'
				dataType: 'html'
				data: {
					method: $method
					type: $type
					action: 'get_rentcafe_data_ajax',
				},
				beforeSend: () ->
					$('html, body').animate({ scrollTop: $rightColumn.offset().top - 30 }, 500)
					$dataLoader.fadeIn()
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					$dataLoader.fadeOut()
					if (data.length)
						response = JSON.parse(data)
						$rentcafeDataContainer.append('<p><strong>RENTCafe URL Lookup:</strong> <a href="' + response.data[0] + '" target="_blank" rel="noopener">' + response.data[0] + '</a></p>')
						$rentcafeDataContainer.append('<p><strong>Data:</strong> ' + response.data[1].body)
					else
						$rentcafeDataContainer.append('no data');
		$('.api_clear_cache').on 'click', (event) ->
			(event).preventDefault()
			$.ajax
				url: ajaxurl
				type: 'POST'
				dataType: 'html'
				data: {
					action: 'delete_rentcafe_transient',
				},
				beforeSend: () ->
					$('.api_clear_cache').addClass('disabled')
					$cacheLoader.fadeIn()
				error: (jqXHR, textStatus, errorThrown) ->
				success: (data, textStatus, jqXHR) ->
					$('.api_clear_cache').removeClass('disabled')
					$cacheLoader.fadeOut()
					$('p.clear-cached-data').append('<strong class="cache-cleared-message">&nbsp;Cache Cleared and Resaved!</strong>')
					$('.cache-cleared-message').delay(3000).fadeOut('normal', () -> $(this).remove())
			return
	return
) jQuery
