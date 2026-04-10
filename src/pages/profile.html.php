<!--
    User Profile Page
    Displays the logged-in user's profile information and allows
    them to update personal details such as name, email and password.
-->

<!-- Display error message if profile update fails -->
<?php if (!empty($error)): ?>
<p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<!-- Profile update form -->
<form id="profileUpdateForm" class="profile-update" action="/account/update" method="post">

    <!-- Inline message area used by JavaScript to display success/error feedback
         without reloading the page. -->
    <p id="profileMessage" class="form-message" aria-live="polite"></p>

    <!-- Page title -->
    <h1>User Profile</h1>

    <!-- First name input (pre-filled with current value) -->
    <label>
        First Name
        <input type="text" name="firstname" value="<?= htmlspecialchars($user['firstname']) ?>">
    </label>

    <!-- Last name input -->
    <label>
        Last Name
        <input type="text" name="lastname" value="<?= htmlspecialchars($user['lastname']) ?>">
    </label>

    <!-- Email input -->
    <label>
        Email
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
    </label>

    <!-- Field used to verify identity before changing password -->
    <label>
        Old Password
        <input type="password" name="oldpassword">
    </label>

    <!-- New password input -->
    <label>
        New Password
        <input type="password" name="newpassword" minlength="6">
    </label>

    <!-- Display user role (disabled so it cannot be modified by the user) -->
    <label>
        Role
        <input type="text" name="role" value="<?= htmlspecialchars($user['role']) ?>" disabled>
    </label>

    <!-- Submit button to update profile details -->
    <button type="submit">Update Profile</button>

    <!-- Logout link to end the user session -->
    <a href="/account/logout">Log out</a>

</form>