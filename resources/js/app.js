import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';

import flatpickr from "flatpickr";

import TomSelect from "tom-select";
window.TomSelect = TomSelect

import ClipboardJS from "clipboard";


var clipboard = new ClipboardJS('.code')

clipboard.on('success', function(e) {
    let oldtext = e.trigger.textContent
    e.trigger.textContent = '✅ Copied!'
    e.clearSelection();
    setTimeout(() => e.trigger.textContent = oldtext, 2000)
});


import './../../vendor/power-components/livewire-powergrid/dist/powergrid'

Livewire.start();
