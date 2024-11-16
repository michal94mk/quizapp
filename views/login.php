<div class="form-wrapper">
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form class="form" action="/login" method="post">
        <input type="text" id="username" name="username" placeholder="Username" class="form-input" required>
        <input type="password" id="password" name="password" placeholder="Password" class="form-input" required>
        <button class="form-btn" type="submit">Login</button>
    </form>
    <a href="/register-form" class="register-now">Don't have an account? Register now.</a>
</div>
