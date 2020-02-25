(($) ->
	'use strict'
	$ ->
		$('#tabs').tabs()
		# Place your administration-specific JavaScript here
		$rentcafeDataContainer = $('#rentcafe-request-data')
		$loader = $('#loader')
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
					$loader.fadeIn()
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					$loader.fadeOut()
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
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					console.log(data, textStatus, jqXHR)
			return
	return
) jQuery
