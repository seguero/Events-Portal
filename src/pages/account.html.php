<header class="page-header">

<!-- Registration Form --> 

    <h1>Register</h1>

    <?php if (!empty($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form id="registerForm"method="post" action="/account/registerSubmit">
    <label>
        First name
        <input type="text" name="firstname" required value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">
    </label>

    <label>
        Last name
        <input type="text" name="lastname" required value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">
    </label>

    <label>
        Email
        <input type="email" name="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>">
    </label>

    <label>
        Password
        <input type="password" name="password" required minlength="6">
    </label>

    <button type="submit">Create account</button>
    </form>

<!-- Login Form -->

    <form id="loginForm"method="post" action="/account/loginSubmit">
    <label>
        Email
        <input type="email" name="email" required value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
    </label>

    <label>
        Password
        <input type="password" name="password" required>
    </label>

    <button type="submit">Log In</button>
    </form>

    <?php if (!empty($login_error)): ?>
        <p class="error"><?= htmlspecialchars($login_error) ?></p>
    <?php endif; ?>
</header>


