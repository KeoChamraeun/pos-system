import $ from 'jquery';
import Popper from 'popper.js';
import 'bootstrap';

// Assign to global scope for Bootstrap 4 plugins to work
window.$ = $;
window.jQuery = $;
window.Popper = Popper;

/**
 * You can initialize Bootstrap plugins here if needed, for example:
 *
 * $(function () {
 *     $('[data-toggle="tooltip"]').tooltip();
 * });
 */
