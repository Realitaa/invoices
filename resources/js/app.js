import './bootstrap';
import "toastify-js/src/toastify.css"
import Toastify from 'toastify-js'
import Alpine from 'alpinejs'
import flatpickr from "flatpickr";
import 'flatpickr/dist/flatpickr.min.css';
import { Indonesian } from "flatpickr/dist/l10n/id.js"

window.Toastify = Toastify
window.Alpine = Alpine

Alpine.start()

// Datepicker initialization after DOMContentLoaded
document.addEventListener('DOMContentLoaded', function () {
    // Localize the datepicker globally
    flatpickr.localize(Indonesian);

    // datepicker
    const datePicker = document.querySelectorAll('[datepicker]');

    datePicker.forEach(function (element) {
        flatpickr(element, {
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
        });
    });
});
