<div class="form-wrapper">
    <form class="form" action="/register" method="POST">
        <input type="text" name="username" placeholder="Username" id="username" class="form-input" required>
        <input type="password" name="password" placeholder="Password" id="password" class="form-input" required>
        <input type="email" name="email" placeholder="Email" id="email" class="form-input" required>
        <button class="form-btn" type="submit">Register</button>
    </form>
    <?php if (isset($message)) echo "<p>$message</p>"; ?>
</div>
