// Example: Validate signup form T&C checkbox before submit
document.addEventListener("DOMContentLoaded", () => {
  const signupForm = document.getElementById("signupForm");
  const termsCheck = document.getElementById("termsCheck");
  const errorMsg = document.getElementById("errorMsg");

  if (signupForm) {
    signupForm.addEventListener("submit", (e) => {
      if (!termsCheck.checked) {
        e.preventDefault();
        errorMsg.style.display = "block";
      } else {
        errorMsg.style.display = "none";
      }
    });
  }
});
