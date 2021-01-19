import flatpickr from 'flatpickr';
import 'flatpickr/dist/flatpickr.min.css';
import 'flatpickr/dist/l10n/fr';

/**
 * Bind individual DatePicker form input
 * @param input DocumentElement
 */
export const bindDatepicker = input => {
    flatpickr(input, {
        dateFormat: "Y-m-d",
        locale: 'fr',
        altInput: true,
        altFormat: 'd/m/Y',
    });
};
