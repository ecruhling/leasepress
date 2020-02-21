(($) ->
	'use strict'
	$ ->
		$('#tabs').tabs()
		# Place your administration-specific JavaScript here
		$('.api_lookup_button').on 'click', (event) ->
			(event).preventDefault()
			$method = $(this).data('method')
			$.ajax
				url: ajaxurl
				type: 'POST'
				dataType: 'html'
				data: {
					method: $method
					action: 'get_data',
				},
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					if (data.length)
						response = JSON.parse(data)
						$('#rentcafe-request-data').append(response.data.body)
					else
						$('#rentcafe-request-data').append('no data');
					console.log(data, textStatus, jqXHR)
					console.log(JSON.parse(data))
			return
	return
) jQuery
