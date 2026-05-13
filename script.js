/* =============================================
   LIMKOKWING UNIVERSITY NAMIBIA - ADMISSIONS JS
   ============================================= */

function submitForm() {
    const requiredFields = [
        'fname', 'lname', 'email', 'phone',
        'dob', 'gender', 'programme', 'entry', 'address'
    ];

    let isValid = true;

    requiredFields.forEach(function (id) {
        const el = document.getElementById(id);
        // Check if element exists first to avoid console errors
        if (el) {
            if (!el.value.trim() || el.value === "") {
                el.style.borderColor = '#c8102e'; // Red border for error
                isValid = false;
            } else {
                el.style.borderColor = '#ccc'; // Reset to neutral
            }
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields marked with *.');
        return;
    }

    // Success UI Flow
    const successMsg = document.getElementById('successMsg');
    successMsg.style.display = 'block';
    
    // Smooth scroll so the user sees the success message
    successMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });

    document.getElementById('appForm').style.opacity = '0.5';
    document.getElementById('appForm').style.pointerEvents = 'none';
    document.querySelector('.form-actions').style.display = 'none';
}

function resetForm() {
    const allFields = [
        'fname', 'lname', 'email', 'phone',
        'dob', 'gender', 'programme', 'entry', 'address', 'motivation'
    ];

    allFields.forEach(function (id) {
        const el = document.getElementById(id);
        if (el) {
            el.value = ''; // Clears text inputs and textareas
            el.style.borderColor = '';
            
            // For <select> elements, reset to the first option
            if (el.tagName === 'SELECT') {
                el.selectedIndex = 0;
            }
        }
    });

    document.getElementById('successMsg').style.display = 'none';
    document.getElementById('appForm').style.opacity = '1';
    document.getElementById('appForm').style.pointerEvents = 'auto';
    document.querySelector('.form-actions').style.display = 'flex';
}
