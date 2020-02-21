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
					action: 'get_data',
				},
				beforeSend: () ->
					$loader.fadeIn()
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					$loader.fadeOut()
					if (data.length)
						response = JSON.parse(data)
						$rentcafeDataContainer.append(response.data.body)
					else
						$rentcafeDataContainer.append('no data');
	#					console.log(data, textStatus, jqXHR)
			return
	return
) jQuery
