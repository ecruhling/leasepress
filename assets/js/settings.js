/*global ajaxurl:true*/

/**
 * settings.js
 *
 * This script is enqueued only on the backend LeasePress pages
 */

(function ($) {
	'use strict'
	$(document).ready(() => {
		// TODO: use some other tab creation
		$('#tabs').tabs() // initialize tabs

		// variables
		const $rentcafeDataContainer = $('#rentcafe-request-data')
		const $rightColumn = $('#right-column')
		const $dataLoader = $('#data-loader')
		const $cacheLoader = $('#cache-loader')

		/**
		 * Generic AJAX function
		 *
		 * @param nonce
		 * @param action
		 * @param beforeSend
		 * @param success
		 * @constructor
		 */
		function AjaxCall (nonce, action, beforeSend, success) {
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'html',
				data: {
					nonce: nonce,
					action: action,
				},
				beforeSend: beforeSend,
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(jqXHR, textStatus, errorThrown)
				},
				success: success
			})
		}

		// Save button click (validation of some fields)
		$('#save-button').on('click', function (e) {
			const $propertyCode = $('#lp_rentcafe_property_code').val()
			const $propertyId = $('#lp_rentcafe_property_id').val()
			const $codeOrId = $('#lp_rentcafe_code_or_id').val()
			if ($codeOrId === 'property_code' && !$propertyCode || $codeOrId === 'property_id' && !$propertyId) {
				e.preventDefault()
				$('.cmb-form').append('<strong class="invalid-code-id">&nbsp;&nbsp;&nbsp;A valid Property Code OR Property ID must be used!</strong>')
			} else {
				$('.invalid-code-id').remove()
			}
		})

		// API clear cache button click
		$('.api_clear_cache').on('click', function (e) {
			e.preventDefault()

			// AJAX call
			new AjaxCall(
				$('#lp_api_clear_cache_nonce').attr('value'),
				'delete_rentcafe_transient',
				function () {
					$('.api_clear_cache').addClass('disabled')
					$cacheLoader.fadeIn()
				},
				function () {
					$('.api_clear_cache').removeClass('disabled')
					$cacheLoader.fadeOut()
					$('p.clear-cached-data').append('<strong class="cache-cleared-message">&nbsp;Cache Cleared and Resaved!</strong>')
					$('.cache-cleared-message').delay(3000).fadeOut('normal', function () {
						$(this).remove()
					})
				},
			)
		})

		// Create / delete floor plans button click
		$('.lp_create_delete_floor_plans').on('click', function (e) {
			e.preventDefault()

			// variables
			const $method = $(this).attr('id')
			const $nonce = $('#' + $method + '_nonce').attr('value')

			// AJAX call
			new AjaxCall(
				$nonce,
				$method,
				function () {
					$('#' + $method).addClass('disabled')
					$('#' + $method + '_loader').fadeIn()
				},
				function (response) {
					const action = ($method === 'lp_create_floor_plans') ? 'Added' : 'Deleted'
					$('#' + $method).removeClass('disabled')
					$('#' + $method + '_loader').fadeOut()
					$('p.' + $method).append('<strong class="floor-plans-message">&nbsp;' + ($.parseJSON(response)).data + ' Floor Plans ' + action + ':</strong>')
					$('.floor-plans-message').delay(3000).fadeOut('normal', function () {
						$(this).remove()
					})
				}
			)
		})

		// API lookup buttons click
		$('.api_lookup_button').on('click', function (e) {
			e.preventDefault()

			// variables
			const $method = $(this).data('method')
			const $type = $(this).data('type')
			let $nonce

			$rentcafeDataContainer.empty() // clear data container

			if ($type) { // if the method type exists, get the nonce value using $method & $type in the name
				$nonce = $('#lp_api_' + $method + '_' + $type + '_lookup_nonce').attr('value')
			} else { // $type does not exist, nonce name uses just the method name
				$nonce = $('#lp_api_' + $method + '_lookup_nonce').attr('value')
			}

			// AJAX call
			$.ajax({
				url: ajaxurl,
				type: 'POST',
				dataType: 'html',
				data: {
					method: $method,
					type: $type,
					action: 'get_rentcafe_data_ajax',
					nonce: $nonce,
				},
				beforeSend: function () {
					$('html, body').animate({
						scrollTop: $rightColumn.offset().top - 30,
					}, 500)
					$dataLoader.fadeIn()
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(jqXHR, textStatus, errorThrown)
				},
				success: function (data) {
					let response
					$dataLoader.fadeOut()
					if (data.length) {
						response = JSON.parse(data)
						$rentcafeDataContainer.append('<p><strong>RENTCafe URL Lookup:</strong> <a href="' + response.data[0] + '" title="RENTCafe URL Lookup" target="_blank" rel="noopener">' + response.data[0] + '</a></p>')
						$rentcafeDataContainer.append('<p><strong>Data:</strong> ' + response.data[1].body)
					} else {
						$rentcafeDataContainer.append('No Data!')
					}
				},
			})
		})

	})
})(jQuery)
