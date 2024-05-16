function toggleCheckboxes(mainCheckbox) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = mainCheckbox.checked;
    });
}