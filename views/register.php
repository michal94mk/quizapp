<div class="register-wrapper">
    <form class="register-form" action="/register" method="POST">
        <input type="text" name="username" placeholder="Username" id="username" required>
        <input type="password" name="password" placeholder="Password" id="password" required>
        <input type="email" name="email" placeholder="Email" id="email" required>
        <button class="register-btn" type="submit">Register</button>
    </form>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
</div>