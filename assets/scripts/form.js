import { bindDatepicker } from './components/datepicker';
import { bindFieldToggle } from './components/form-field-toggle';

[...document.querySelectorAll('input[data-datepicker]')].forEach(bindDatepicker);
[...document.querySelectorAll('[data-form-field-toggle]')].forEach(bindFieldToggle);
