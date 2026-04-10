/*
 * Edit Event AJAX Script
 *
 * Submits the admin edit-event form asynchronously,
 * displays inline success/error messages, and redirects
 * back to the admin dashboard after a successful update.
 */

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("editEventForm");
  const message = document.getElementById("editEventMessage");

  if (!form || !message) {
    return;
  }

  /* Clear any existing message */
  function clearMessage() {
    message.textContent = "";
    message.classList.remove("success", "error");
  }

  /* Display feedback message */
  function showMessage(text, type) {
    message.textContent = text;
    message.classList.remove("success", "error");
    message.classList.add(type);
  }

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    clearMessage();

    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.innerHTML;

    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fa-solid fa-spinner"></i> Updating...';

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
        showMessage(data.message + " Redirecting...", "success");

        setTimeout(() => {
          window.location.href = data.redirect || "/admin";
        }, 1500);
      } else {
        showMessage(data.message || "Unable to update event.", "error");
      }
    } catch (error) {
      showMessage("Unable to update event. Please try again.", "error");
    } finally {
      submitButton.disabled = false;
      submitButton.innerHTML = originalButtonText;
    }
  });
});
