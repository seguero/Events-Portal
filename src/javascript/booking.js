/*
 * Booking AJAX Script
 *
 * Submits the event booking form asynchronously
 * and shows inline success/error feedback
 * without reloading the page.
 */

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("bookingForm");
  const message = document.getElementById("bookingMessage");

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
    submitButton.textContent = "Booking...";

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
        showMessage(data.message || "Event booked successfully.", "success");

        /* Disable the form after successful booking */
        submitButton.disabled = true;
        submitButton.textContent = "Booked";

        if (data.alreadyBookedText) {
          setTimeout(() => {
            form.innerHTML = `<p>${data.alreadyBookedText}</p>`;
          }, 1500);
        }
      } else {
        showMessage(data.message || "Unable to complete booking.", "error");
        submitButton.disabled = false;
        submitButton.textContent = originalButtonText;
      }
    } catch (error) {
      showMessage("Unable to complete booking. Please try again.", "error");
      submitButton.disabled = false;
      submitButton.textContent = originalButtonText;
    }
  });
});
