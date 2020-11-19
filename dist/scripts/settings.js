/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./assets/js/settings.js":
/*!*******************************!*\
  !*** ./assets/js/settings.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports) {

/*global ajaxurl:true*/

/**
 * settings.js
 *
 * This script is enqueued only on the backend LeasePress pages
 */
(function ($) {
  'use strict';

  $(document).ready(function () {
    // TODO: use some other tab creation
    $('#tabs').tabs(); // initialize tabs
    // variables

    var $rentcafeDataContainer = $('#rentcafe-request-data');
    var $rightColumn = $('#right-column');
    var $dataLoader = $('#data-loader');
    var $cacheLoader = $('#cache-loader');
    /**
     * Generic AJAX function
     *
     * @param nonce
     * @param action
     * @param beforeSend
     * @param success
     * @constructor
     */

    function AjaxCall(nonce, action, beforeSend, success) {
      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          nonce: nonce,
          action: action
        },
        beforeSend: beforeSend,
        error: function error(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR, textStatus, errorThrown);
        },
        success: success
      });
    } // Save button click (validation of some fields)


    $('#save-button').on('click', function (e) {
      var $propertyCode = $('#lp_rentcafe_property_code').val();
      var $propertyId = $('#lp_rentcafe_property_id').val();
      var $codeOrId = $('#lp_rentcafe_code_or_id').val();

      if ($codeOrId === 'property_code' && !$propertyCode || $codeOrId === 'property_id' && !$propertyId) {
        e.preventDefault();
        $('.cmb-form').append('<strong class="invalid-code-id">&nbsp;&nbsp;&nbsp;A valid Property Code OR Property ID must be used!</strong>');
      } else {
        $('.invalid-code-id').remove();
      }
    }); // API clear cache button click

    $('.api_clear_cache').on('click', function (e) {
      e.preventDefault(); // AJAX call

      new AjaxCall($('#lp_api_clear_cache_nonce').attr('value'), 'delete_rentcafe_transient', function () {
        $('.api_clear_cache').addClass('disabled');
        $cacheLoader.fadeIn();
      }, function () {
        $('.api_clear_cache').removeClass('disabled');
        $cacheLoader.fadeOut();
        $('p.clear-cached-data').append('<strong class="cache-cleared-message">&nbsp;Cache Cleared and Resaved!</strong>');
        $('.cache-cleared-message').delay(3000).fadeOut('normal', function () {
          $(this).remove();
        });
      });
    }); // Create / delete floor plans button click

    $('.lp_create_delete_floor_plans').on('click', function (e) {
      e.preventDefault(); // variables

      var $method = $(this).attr('id');
      var $nonce = $('#' + $method + '_nonce').attr('value'); // AJAX call

      new AjaxCall($nonce, $method, function () {
        $('#' + $method).addClass('disabled');
        $('#' + $method + '_loader').fadeIn();
      }, function (response) {
        var action = $method === 'lp_create_floor_plans' ? 'Added' : 'Deleted';
        $('#' + $method).removeClass('disabled');
        $('#' + $method + '_loader').fadeOut();
        $('p.' + $method).append('<strong class="floor-plans-message">&nbsp;' + $.parseJSON(response).data + ' Floor Plans ' + action + ':</strong>');
        $('.floor-plans-message').delay(3000).fadeOut('normal', function () {
          $(this).remove();
        });
      });
    }); // API lookup buttons click

    $('.api_lookup_button').on('click', function (e) {
      e.preventDefault(); // variables

      var $method = $(this).data('method');
      var $type = $(this).data('type');
      var $nonce;
      $rentcafeDataContainer.empty(); // clear data container

      if ($type) {
        // if the method type exists, get the nonce value using $method & $type in the name
        $nonce = $('#lp_api_' + $method + '_' + $type + '_lookup_nonce').attr('value');
      } else {
        // $type does not exist, nonce name uses just the method name
        $nonce = $('#lp_api_' + $method + '_lookup_nonce').attr('value');
      } // AJAX call


      $.ajax({
        url: ajaxurl,
        type: 'POST',
        dataType: 'html',
        data: {
          method: $method,
          type: $type,
          action: 'get_rentcafe_data_ajax',
          nonce: $nonce
        },
        beforeSend: function beforeSend() {
          $('html, body').animate({
            scrollTop: $rightColumn.offset().top - 30
          }, 500);
          $dataLoader.fadeIn();
        },
        error: function error(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR, textStatus, errorThrown);
        },
        success: function success(data) {
          var response;
          $dataLoader.fadeOut();

          if (data.length) {
            response = JSON.parse(data);
            $rentcafeDataContainer.append('<p><strong>RENTCafe URL Lookup:</strong> <a href="' + response.data[0] + '" title="RENTCafe URL Lookup" target="_blank" rel="noopener">' + response.data[0] + '</a></p>');
            $rentcafeDataContainer.append('<p><strong>Data:</strong> ' + response.data[1].body);
          } else {
            $rentcafeDataContainer.append('No Data!');
          }
        }
      });
    });
  });
})(jQuery);

/***/ }),

/***/ 2:
/*!*************************************!*\
  !*** multi ./assets/js/settings.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/erik/Sites/test.resourceatlanta.test/wp-content/plugins/leasepress/assets/js/settings.js */"./assets/js/settings.js");


/***/ })

/******/ });
//# sourceMappingURL=settings.js.map