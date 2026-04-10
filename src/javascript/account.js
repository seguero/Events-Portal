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

  /* Get references to inline AJAX message for each form. */
  const loginMessage = document.getElementById("loginMessage");
  const registerMessage = document.getElementById("registerMessage");

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

  /* Clear any previous success/error message from a form. */
  function clearMessage(element) {
    if (!element) return;
    element.textContent = "";
    element.classList.remove("success", "error");
  }

  /* Display a success or error message inside a form. */
  function showMessage(element, message, type) {
    if (!element) return;
    element.textContent = message;
    element.classList.remove("success", "error");
    element.classList.add(type);
  }

  /* Submit a form using fetch so validation messages can be shown
     without reloading the page. */
  async function handleAjaxSubmit(form, messageElement) {
    clearMessage(messageElement);

    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.textContent;

    submitButton.disabled = true;
    submitButton.textContent = "Please wait...";

    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          Accept: "application/json",
        },
      });

      const data = await response.json();

      if (data.success) {
        showMessage(
          messageElement,
          data.message + " Redirecting...",
          "success",
        );
        if (data.redirect) {
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1500);
        }
      } else {
        showMessage(
          messageElement,
          data.message || "Something went wrong.",
          "error",
        );
      }
    } catch (error) {
      showMessage(
        messageElement,
        "Unable to reach the server. Please try again.",
        "error",
      );
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = originalButtonText;
    }
  }

  /* Attach click events to switch between tabs */
  loginTab.addEventListener("click", showLogin);
  registerTab.addEventListener("click", showRegister);

  /* Intercept login form submission and send it through fetch. */
  loginForm.addEventListener("submit", (event) => {
    event.preventDefault();
    handleAjaxSubmit(loginForm, loginMessage);
  });

  /* ntercept register form submission and send it through fetch. */
  registerForm.addEventListener("submit", (event) => {
    event.preventDefault();
    handleAjaxSubmit(registerForm, registerMessage);
  });

  /* Set login form as the default visible tab */
  showLogin();
});
