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
				async: true
				data: {
					method: $method
					action: 'get_data',
				},
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					console.log(data, textStatus, jqXHR)
			return
	return
) jQuery
