<div class="login-wrapper">
<?php if (isset($error)): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>
    <form class="login-form" action="/login" method="post">
        <input type="text" id="username" name="username" placeholder="Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>
        <button class="login-btn" type="submit">Login</button>
    </form>
    <a href="/register-form" class="register-now">Don't have account? Register now.</a>
</div>