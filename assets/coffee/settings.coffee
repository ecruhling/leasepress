(($) ->
	'use strict'
	$ ->
		$('#tabs').tabs()
		# Place your administration-specific JavaScript here
		$('#lp_api_floorplans_lookup_submit').on 'click', (event) ->
			(event).preventDefault()
			console.log 'works'
			$.ajax
				url: ajaxurl
				data: {
					action: 'get_data',
				},
				error: (jqXHR, textStatus, errorThrown) ->
					console.log(jqXHR, textStatus, errorThrown)
				success: (data, textStatus, jqXHR) ->
					console.log(data, textStatus, jqXHR)
			return
	return
) jQuery
