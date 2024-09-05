<h1>Edytuj Użytkownika</h1>
<form action="/admin/update-user" method="POST">
    <input type="hidden" id="id" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">

    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>">
    <br>

    <label for="password">Nowe hasło (pozostaw puste, aby nie zmieniać):</label>
    <input type="password" id="password" name="password">
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <br>

    <label for="role">Rola:</label>
    <select id="role" name="role">
        <option value="user" <?php if ($user['role'] == 'user') echo 'selected'; ?>>Użytkownik</option>
        <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Administrator</option>
    </select>
    <br>

    <button type="submit">Zaktualizuj użytkownika</button>
</form>
