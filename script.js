// Wait for the DOM to fully load before running scripts
document.addEventListener("DOMContentLoaded", () => {
    
    // 1. FORM VALIDATION (For Contact Us / Admissions Page)
    const contactForm = document.getElementById("contact-form");
    
    if (contactForm) {
        contactForm.addEventListener("submit", (e) => {
            const name = document.getElementById("name").value;
            const email = document.getElementById("email").value;
            const message = document.getElementById("message").value;

            // Simple check to see if fields are empty
            if (name === "" || email === "" || message === "") {
                e.preventDefault(); // Stop the form from submitting
                alert("Please fill in all required fields.");
            } else {
                alert("Thank you, " + name + "! Your message has been sent.");
            }
        });
    }

    // 2. INTERACTIVE ANNOUNCEMENT (Example for Home Page)
    const highlight = document.querySelector(".hero h1");
    if (highlight) {
        highlight.addEventListener("click", () => {
            highlight.style.color = "#FFD700"; // Change color to Gold on click
            console.log("Welcome message clicked!");
        });
    }
});