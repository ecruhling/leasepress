// Place your ADMINISTRATION-SPECIFIC JavaScript here
import { createPopper } from '@popperjs/core'

(function ($) {
	'use strict'
	// $(function () {
		const tooltip = document.querySelector('.lp-tooltip')
		createPopper(tooltip, {
			placement: 'top',
		})
	// })
})(jQuery)
