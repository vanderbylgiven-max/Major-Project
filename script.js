
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
        if (el) {
            if (!el.value.trim() || el.value === "") {
                el.style.borderColor = '#c8102e';
                isValid = false;
            } else {
                el.style.borderColor = '#ccc';
            }
        }
    });

    if (!isValid) {
        alert('Please fill in all required fields marked with *.');
        return;
    }

    const successMsg = document.getElementById('successMsg');
    successMsg.style.display = 'block';
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
            el.value = '';
            el.style.borderColor = '';
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

function downloadVisitorList() {
    const name = localStorage.getItem("visitorName");
    const age = localStorage.getItem("visitorAge");

    if (!name || !age) {
        alert("No visitor data found from the news page.");
        return;
    }

    const csv = "Name,Age\n" + name + "," + age;
    const blob = new Blob([csv], { type: "text/csv" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = "visitor_list.csv";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


/* =============================================
   LOGIN PAGE
   ============================================= */

const API = 'api.php';

function showRegister() {
    document.getElementById("loginForm").style.display    = "none";
    document.getElementById("forgotForm").style.display   = "none";
    document.getElementById("registerForm").style.display = "block";
    clearError();
}

function showLogin() {
    document.getElementById("registerForm").style.display = "none";
    document.getElementById("forgotForm").style.display   = "none";
    document.getElementById("loginForm").style.display    = "block";
    clearError();
}

function showForgot() {
    document.getElementById("loginForm").style.display    = "none";
    document.getElementById("registerForm").style.display = "none";
    document.getElementById("forgotForm").style.display   = "block";
    clearError();
}

async function register() {
    const password        = document.getElementById("newPassword").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

    if (password !== confirmPassword)
        return showError("Passwords do not match");

    const body = new FormData();
    body.append('action',   'register');
    body.append('fullName', document.getElementById("fullName").value);
    body.append('username', document.getElementById("newUsername").value);
    body.append('email',    document.getElementById("email").value);
    body.append('password', password);

    const res  = await fetch(API, { method: 'POST', body });
    const data = await res.json();

    if (data.success) {
        showSuccess("Account created successfully");
        showLogin();
    } else {
        showError(data.message);
    }
}

async function login() {
    const body = new FormData();
    body.append('action',   'login');
    body.append('username', document.getElementById("loginUsername").value);
    body.append('password', document.getElementById("loginPassword").value);

    const res  = await fetch(API, { method: 'POST', body });
    const data = await res.json();

    if (data.success) {
        localStorage.setItem("loggedIn",    "true");
        localStorage.setItem("studentName", data.name);
        localStorage.setItem("studentID",   data.studentID);
        window.location.href = "student-dashboard.html";
    } else {
        showError(data.message);
    }
}

async function resetPassword() {
    const pass    = document.getElementById("forgotPassword").value;
    const confirm = document.getElementById("forgotConfirmPassword").value;

    if (pass !== confirm)
        return showError("Passwords do not match");

    const body = new FormData();
    body.append('action',   'resetPassword');
    body.append('username', document.getElementById("forgotUsername").value);
    body.append('email',    document.getElementById("forgotEmail").value);
    body.append('password', pass);

    const res  = await fetch(API, { method: 'POST', body });
    const data = await res.json();

    if (data.success) {
        showSuccess("Password reset successful");
        showLogin();
    } else {
        showError(data.message);
    }
}

function showError(msg) {
    const e = document.getElementById("error");
    e.style.color = "red";
    e.innerText   = msg;
}

function showSuccess(msg) {
    const e = document.getElementById("error");
    e.style.color = "green";
    e.innerText   = msg;
}

function clearError() {
    const e = document.getElementById("error");
    if (e) e.innerText = "";
}

function togglePassword()             { toggle("loginPassword"); }
function toggleRegisterPassword()     { toggle("newPassword"); }
function toggleConfirmPassword()      { toggle("confirmPassword"); }
function toggleForgotPassword()       { toggle("forgotPassword"); }
function toggleForgotConfirmPassword(){ toggle("forgotConfirmPassword"); }

function toggle(id) {
    const el = document.getElementById(id);
    el.type  = el.type === "password" ? "text" : "password";
}