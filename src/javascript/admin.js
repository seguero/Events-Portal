/*
 * Admin Search Script
 *
 * Handles AJAX searching on the admin events page.
 * As the administrator types in the search box, a request
 * is sent to the server and the events table updates
 * without reloading the page.
 */

document.addEventListener("DOMContentLoaded", () => {
  /* Get references to the search input and table body */
  const searchInput = document.getElementById("event-search-input");
  const tableBody = document.querySelector(".admin-table tbody");

  /* Stop if this script is loaded on a page without the admin table */
  if (!searchInput || !tableBody) {
    return;
  }

  let debounceTimer;

  /* Escape HTML characters before inserting text into the DOM */
  function escapeHtml(text) {
    const div = document.createElement("div");
    div.textContent = text ?? "";
    return div.innerHTML;
  }

  /* Render the list of events into the table body */
  function renderEvents(events) {
    if (!events || events.length === 0) {
      tableBody.innerHTML = `
        <tr>
          <td colspan="7" class="no-results">No events found.</td>
        </tr>
      `;
      return;
    }

    tableBody.innerHTML = events
      .map(
        (event) => `
      <tr>
        <td>${event.eventid}</td>
        <td>${escapeHtml(event.title)}</td>
        <td>${escapeHtml(event.event_type)}</td>
        <td>${escapeHtml(event.category)}</td>
        <td>${escapeHtml(event.event_date)}</td>
        <td>${escapeHtml(event.location)}</td>
        <td class="actions">
          <a href="/admin/edit?id=${event.eventid}" class="edit">
            <i class="fa-solid fa-pen"></i>
          </a>
          <a href="/admin/delete?id=${event.eventid}" class="delete"
             onclick="return confirm('Delete this event?')">
            <i class="fa-solid fa-trash"></i>
          </a>
        </td>
      </tr>
    `,
      )
      .join("");
  }

  /* Show an error row inside the table */
  function renderError(message) {
    tableBody.innerHTML = `
      <tr>
        <td colspan="7" class="no-results">${escapeHtml(message)}</td>
      </tr>
    `;
  }

  /* Request filtered events from the server */
  async function searchEvents(query) {
    try {
      const response = await fetch(
        `/admin/search?q=${encodeURIComponent(query)}`,
        {
          headers: {
            "X-Requested-With": "XMLHttpRequest",
            Accept: "application/json",
          },
        },
      );

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

  /* Debounced input event for smoother searching */
  searchInput.addEventListener("input", () => {
    clearTimeout(debounceTimer);

    debounceTimer = setTimeout(() => {
      searchEvents(searchInput.value.trim());
    }, 300);
  });
});
