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

function getVisitorRecords() {
  try {
    return JSON.parse(localStorage.getItem('newsVisitors') || '[]');
  } catch (e) {
    return [];
  }
}

function saveVisitorRecord(name, age) {
  const records = getVisitorRecords();
  records.push({
    name: name,
    age: age,
    page: 'Namibian News',
    date: new Date().toISOString()
  });
  localStorage.setItem('newsVisitors', JSON.stringify(records));
  return records;
}

function formatRecordsToCsv(records) {
  const header = ['Name', 'Age', 'Page', 'Date'];
  const rows = records.map(record => {
    return [record.name, record.age, record.page, record.date]
      .map(value => '"' + String(value).replace(/"/g, '""') + '"')
      .join(',');
  });
  return [header.join(','), ...rows].join('\r\n');
}

function downloadVisitorCsv(records) {
  if (!records || !records.length) {
    alert('No visitor records found yet.');
    return;
  }

  const csv = formatRecordsToCsv(records);
  const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
  const url = URL.createObjectURL(blob);
  const link = document.createElement('a');
  link.href = url;
  link.download = 'news_visitors.csv';
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
  URL.revokeObjectURL(url);
}

function saveVisitorAndOpenNews(name, age) {
  saveVisitorRecord(name, age);
  window.open('https://www.namibian.com.na', '_blank', 'noopener');
}

function downloadVisitorList() {
  const records = getVisitorRecords();
  if (!records.length) {
    alert('No visitor records found yet.');
    return;
  }
  downloadVisitorCsv(records);
}
