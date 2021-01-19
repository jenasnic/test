import axios from 'axios';

export const bindFieldToggle = (field) => {
    field.addEventListener('change', () => {
        reloadData(field);
    });
};

const reloadData = (element) => {
    const wrapper = document.getElementById(element.dataset.formFieldToggle);
    const formData = new FormData();
    formData.append(element.name, element.value);
    formData.append('_method', 'PATCH');

    const actionUrl = element.closest('form').action;

    axios.post(actionUrl, formData)
        .then(response => {
            console.log(response);
            const result = new DOMParser().parseFromString(response.data, 'text/html').getElementById(element.dataset.formFieldToggle);
            document.getElementById(element.dataset.formFieldToggle).innerHTML = result.innerHTML;
        })
    ;
};
