/*
 * Create Event AJAX Script
 *
 * Submits the admin create-event form asynchronously,
 * displays inline success/error messages, and redirects
 * back to the admin dashboard after a successful save.
 */

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("createEventForm");
  const message = document.getElementById("createEventMessage");

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
    submitButton.innerHTML = '<i class="fa-solid fa-spinner"></i> Saving...';

    try {
      const response = await fetch(form.action, {
        method: "POST",
        body: new FormData(form),
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          Accept: "application/json",
        },
      });

      const text = await response.text();

      let data;

      try {
        data = JSON.parse(text);
      } catch (error) {
        console.error("Invalid server response:", text);
        showMessage(
          "Server returned an invalid response. Check the console.",
          "error",
        );
        return;
      }

      if (!response.ok || !data.success) {
        showMessage(data.message || "Unable to save event.", "error");
        return;
      }

      showMessage(data.message + " Redirecting...", "success");

      setTimeout(() => {
        window.location.href = data.redirect || "/admin";
      }, 1500);
    } catch (error) {
      console.error(error);
      showMessage("Server could not be reached. Please try again.", "error");
    }
  });
});
