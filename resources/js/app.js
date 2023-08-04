import flatpickr from "flatpickr";

window.flatpickr = flatpickr

import("./../../node_modules/flatpickr/dist/flatpickr.min.css");
import("./../../vendor/power-components/livewire-powergrid/dist/powergrid.css");
import("./../../vendor/power-components/livewire-powergrid/dist/tom-select.css");

import TomSelect from "tom-select";
window.TomSelect = TomSelect

import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

import JSConfetti from 'js-confetti'

const jsConfetti = new JSConfetti()

window.confetti = () => jsConfetti.addConfetti()
