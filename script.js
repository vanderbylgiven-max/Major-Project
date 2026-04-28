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
    if (!el.value.trim()) {
      el.style.borderColor = '#c8102e';
      isValid = false;
    } else {
      el.style.borderColor = '';
    }
  });

  if (!isValid) {
    alert('Please fill in all required fields marked with *.');
    return;
  }

  document.getElementById('successMsg').style.display = 'block';
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
    el.value = '';
    el.style.borderColor = '';
  });

  document.getElementById('successMsg').style.display = 'none';
  document.getElementById('appForm').style.opacity = '1';
  document.getElementById('appForm').style.pointerEvents = 'auto';
  document.querySelector('.form-actions').style.display = 'flex';
}
