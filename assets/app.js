/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss'

// start the Stimulus application
import './bootstrap'

const $ = require('jquery')
global.$ = global.jQuery = $
// this "modifies" the jquery module: adding behavior to it
// the bootstrap module doesn't export/return anything
require('bootstrap')

// fontawesome
require('@fortawesome/fontawesome-free/css/all.min.css')
require('@fortawesome/fontawesome-free/js/all.min.js')

// slick carousel
require('slick-carousel/slick/slick.scss')
require('slick-carousel/slick/slick-theme.scss')
require('slick-carousel/slick/slick.min.js')

// preloader
window.addEventListener('load',function() {
    var body = $('body')
    body.addClass('loaded_hiding')
    window.setTimeout(function () {
        body.addClass('loaded')
        body.removeClass('loaded_hiding')
    }, 500)
})