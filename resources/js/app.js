window.Popper = require('popper.js').default;
window.$ = window.jQuery = require('jquery');

window.bootstrap = require('bootstrap');

import Alpine from 'alpinejs'
import flatpickr from "flatpickr";

window.Alpine = Alpine
window.flatpickr = flatpickr

require("./../../node_modules/flatpickr/dist/flatpickr.min.css");
require('./../../node_modules/bootstrap-select/dist/js/bootstrap-select');
require("./../../node_modules/bootstrap-select/dist/css/bootstrap-select.min.css");

import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

Alpine.start()
