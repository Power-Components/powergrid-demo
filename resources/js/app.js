import Alpine from 'alpinejs'
import flatpickr from "flatpickr";

window.Alpine = Alpine
window.flatpickr = flatpickr

require("./../../node_modules/flatpickr/dist/flatpickr.min.css");

import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

Alpine.start()
