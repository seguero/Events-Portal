/*
 * Public Events Search and Filter Script
 *
 * Handles AJAX searching and filtering on the public events page.
 * User input from the search bar and filter controls is sent to the server,
 * which returns JSON data used to update the event cards without reloading.
 */

document.addEventListener("DOMContentLoaded", () => {
  /* Get references to the search input, filter form, and card container */
  const searchInput = document.getElementById("event-search-input");
  const filterForm = document.getElementById("events-filter-form");
  const eventsList = document.querySelector(".events-list");

  /* Stop if this script is loaded on a page without the events UI */
  if (!searchInput || !filterForm || !eventsList) {
    return;
  }

  let debounceTimer;

  /* Escape HTML before inserting dynamic content */
  function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text ?? "";
    return div.innerHTML;
  }

  /* Format MySQL datetime type into a readable display format */
  function formatEventDate(dateString) {
    if (!dateString) {
      return "";
    }

    const date = new Date(dateString.replace(" ", "T"));

    if (Number.isNaN(date.getTime())) {
      return dateString;
    }

    return date.toLocaleString("en-GB", {
      day: "2-digit",
      month: "short",
      year: "numeric",
      hour: "2-digit",
      minute: "2-digit",
    });
  }

  /* Render event cards */
  function renderEvents(events) {
    if (!events || events.length === 0) {
      eventsList.innerHTML = `
        <p class="events-empty">No events found.</p>
      `;
      return;
    }

    eventsList.innerHTML = events
      .map(
        (event) => `
      <article class="card card-event">
        <img
          class="card-media"
          src="../assets/placeholder.jpg"
          alt="Event"
        />

        <div class="card-body">
          <span class="badge">${escapeHtml(event.event_type)}</span>
          <h3 class="card-title">${escapeHtml(event.title)}</h3>
          <p class="card-meta">${escapeHtml(formatEventDate(event.event_date))}</p>
          <p class="card-text">${escapeHtml(event.location)}</p>
          <a class="card-cta" href="/events/show/${event.eventid}">Read more</a>
        </div>
      </article>
    `,
      )
      .join("");
  }

  /* Render friendly error message */
  function renderError(message) {
    eventsList.innerHTML = `
      <p class="events-empty">${escapeHtml(message)}</p>
    `;
  }

  /* Build query string from both search bar and filter form */
  function buildQueryString() {
    const params = new URLSearchParams();
    const formData = new FormData(filterForm);

    /* Add search input */
    params.set("q", searchInput.value.trim());

    /* Add filter form values */
    for (const [key, value] of formData.entries()) {
      params.append(key, value);
    }

    return params.toString();
  }

  /* Request filtered events from the server */
  async function updateEvents() {
    try {
      const queryString = buildQueryString();

      const response = await fetch(`/events/search?${queryString}`, {
        headers: {
          "X-Requested-With": "XMLHttpRequest",
          Accept: "application/json",
        },
      });

      const data = await response.json();

      if (!response.ok || !data.success) {
        renderError(data.message || "Unable to load events.");
        return;
      }

      renderEvents(data.events);
    } catch (error) {
      renderError("Server could not be reached. Please try again.");
    }
  }

  /* Debounced search input */
  searchInput.addEventListener("input", () => {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
      updateEvents();
    }, 300);
  });

  /* Immediate update for all filter controls */
  filterForm.addEventListener("change", () => {
    updateEvents();
  });
});
