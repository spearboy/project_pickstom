function toggleCheckboxes(mainCheckbox) {
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = mainCheckbox.checked;
    });
}

function updateMainCheckbox() {
    const mainCheckbox = document.getElementById('checkbox1');
    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="checkbox"]:not(#checkbox1)');
    mainCheckbox.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
}