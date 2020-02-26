(($) ->
	'use strict'
	$ ->
		$('#tabs').tabs()
		# Place your administration-specific JavaScript here
		$rentcafeDataContainer = $('#rentcafe-request-data')
		$dataLoader = $('#data-loader')
		$cacheLoader = $('#cache-loader')
		$('.api_lookup_button').on 'click', (event) ->
			(event).preventDefault()
			$rentcafeDataContainer.empty()
			$method = $(this).data('method')
			$.ajax
				url: ajaxurl
				type: 'POST'
				dataType: 'html'
				data: {
					method: $method
					action: 'get_rentcafe_data_ajax',
				},
				beforeSend: () ->
					$dataLoader.fadeIn()
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					$dataLoader.fadeOut()
					if (data.length)
						response = JSON.parse(data)
						$rentcafeDataContainer.append('<p><strong>RENTCafe URL Lookup:</strong> ' + response.data[0] + '</p>')
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
#					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					$('.api_clear_cache').removeClass('disabled')
					$cacheLoader.fadeOut()
					$('p.clear-cached-data').append('<strong class="cache-cleared-message">&nbsp;Cache Cleared and Regenerated!</strong>')
					$('.cache-cleared-message').delay(3000).fadeOut('normal', () -> $(this).remove())
			#					console.log(data, textStatus, jqXHR)
			return
	return
) jQuery
