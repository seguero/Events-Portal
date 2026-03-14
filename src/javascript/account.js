/*
 * Account Tabs Script
 *
 * Controls the tab switching between the login and register forms
 * on the account page without reloading the page.
 */

document.addEventListener("DOMContentLoaded", () => {
  /* Get references to the tab buttons */
  const loginTab = document.getElementById("loginTab");
  const registerTab = document.getElementById("registerTab");

  /* Get references to the corresponding forms */
  const loginForm = document.getElementById("loginForm");
  const registerForm = document.getElementById("registerForm");

  /* Show the login form and highlight the login tab */
  function showLogin() {
    loginForm.classList.add("active");
    registerForm.classList.remove("active");

    loginTab.classList.add("active");
    registerTab.classList.remove("active");
  }

  /* Show the registration form and highlight the register tab */
  function showRegister() {
    registerForm.classList.add("active");
    loginForm.classList.remove("active");

    registerTab.classList.add("active");
    loginTab.classList.remove("active");
  }

  /* Attach click events to switch between tabs */
  loginTab.addEventListener("click", showLogin);
  registerTab.addEventListener("click", showRegister);

  /* Set login form as the default visible tab */
  showLogin();
});
