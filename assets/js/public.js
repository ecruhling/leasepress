// import svg-injector
import SVGInjector from 'svg-injector'

/**
 * public.js
 *
 * This script is enqueued only on the frontend,
 * and only on the page template as selected in the
 * settings area 'Template for Floor Plans page'
 */

(function ($) {
	'use strict'
	$(function () {
		// Write in console log the PHP value passed in enqueue_js_vars in public/class-plugin-name.php
		// console.log(pn_js_vars.alert)
	})

	$(document).ready(() => {

		console.log('floor plans page template')
		/**
		 * Variables
		 */
		const injectedSVGs = $('img[src$=".svg"]') // all SVG files - img src ends with ( &= ) svg
		const injectorOptions = {
			evalScripts: 'never',
		}

		/**
		 * Inject and create inline SVGs (site plans)
		 * then run a callback function to create the interactivity
		 */
		new SVGInjector(injectedSVGs, injectorOptions, function () {

			// Variables
			const $units = $('.injected-svg g[id^="units"] [id^="unit"]') // all individual units

			$units.addClass('unavailable') // add unavailable class to all units
			$('#site-plans-content').prepend($('.tooltip-info-box')) // move all tooltip boxes to #site-plans-content (main site plan container)

			$('.unit-data').each(function () {

				const number = $(this).data('number') // unit-xxx
				// remove unavailable class on units that have data
				$('.injected-svg [id = "' + number + '"]').removeClass('unavailable') // selector written like this because there are multiple g(units) with the same id

			})

			// Hover function for individual units
			$units.hover(
				function () {
					const unit = $(this).attr('id')
					const main = $('#site-plans-content')
					const offset = $(this).offset()
					const offsetLeft = offset.left - main.offset().left
					const offsetTop = offset.top - main.offset().top
					const position = {
						left: offsetLeft + 50,
						top: offsetTop,
					}

					$('#' + unit + 'InfoBox').css(position).fadeIn(200)
				},
				function () {
					$('.tooltip-info-box').fadeOut(200)
				}  // for mouse out
			).click(
				function () {
					const unit = $(this).attr('id')
					$('#' + unit + '-modal').modal('show')
				}
			)

		})

	})

})(jQuery)
