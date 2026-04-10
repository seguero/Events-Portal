/*
 * Profile Update AJAX Script
 *
 * Submits the profile update form asynchronously
 * and displays inline success/error messages
 * without reloading the page.
 */

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("profileUpdateForm");
  const message = document.getElementById("profileMessage");

  if (!form || !message) {
    return;
  }

  function clearMessage() {
    message.textContent = "";
    message.classList.remove("success", "error");
  }

  function showMessage(text, type) {
    message.textContent = text;
    message.classList.remove("success", "error");
    message.classList.add(type);
  }

  form.addEventListener("submit", async (event) => {
    event.preventDefault();
    clearMessage();

    const submitButton = form.querySelector('button[type="submit"]');
    const originalButtonText = submitButton.textContent;

    submitButton.disabled = true;
    submitButton.textContent = "Updating...";

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
        showMessage(data.message || "Profile updated successfully.", "success");
      } else {
        showMessage(data.message || "Unable to update profile.", "error");
      }
    } catch (error) {
      showMessage("Unable to update profile. Please try again.", "error");
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = originalButtonText;
    }
  });
});
