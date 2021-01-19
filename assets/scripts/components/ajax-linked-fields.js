/**
 * Allows to bind an element depending on another one using Symfony form validation.
 * Use 'data-field-dependency' property with identifier of field to check in order to refresh current element.
 * NOTE : Implement Symfony using FormEvents to set data...
 *
 * @param element
 */
export const bindFieldDependency = (element) => {
    document.getElementById(element.dataset.fieldDependency).addEventListener('change', () => {
        reloadData(element);
    });
};

/**
 * Allows to reload data when updating dependency field using Symfony form validation.
 *
 * @param element DOM element to update.
 */
const reloadData = (element) => {
    const fieldDependency = document.getElementById(element.dataset.fieldDependency);
    const formData = new FormData();
    formData.append(fieldDependency.name, fieldDependency.value);
    formData.append('_method', 'PATCH');

    const actionUrl = element.closest('form').action;
    fetch(actionUrl, {
        credentials: 'same-origin',
        method: 'POST',
        body: formData,
    })
        .then(response => response.text())
        .then(
            response => {
                const elementId = element.id;
                const elementToUpdate = document.getElementById(elementId);
                elementToUpdate.innerHTML = new DOMParser().parseFromString(response, 'text/html').getElementById(elementId).innerHTML;
            }
        )
    ;
};
