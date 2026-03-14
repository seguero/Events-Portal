<header class="page-header">
        <h1>Account</h1>
</header>

<!-- Registration Form --> 
    <div class="auth-container">

        <div class="auth-tabs">
            <button id="loginTab" class="auth-tab active">Login</button>
            <button id="registerTab" class="auth-tab">Register</button>
        </div>


        <?php if (!empty($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form id="registerForm" class="auth-form"method="post" action="/account/registerSubmit">
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

        <form id="loginForm" class="auth-form active" method="post" action="/account/loginSubmit">
        <label>
            Email
            <input type="email" name="email" required value="<?= htmlspecialchars($login_old['email'] ?? '') ?>">        
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

    </div>
