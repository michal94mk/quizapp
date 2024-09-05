<h1>Dodaj Użytkownika</h1>
<form action="/admin/add-user" method="POST">
    <label for="username">Nazwa użytkownika:</label>
    <input type="text" id="username" name="username" required>
    <br>

    <label for="password">Hasło:</label>
    <input type="text" id="password" name="password" required>
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br>

    <label for="role">Rola:</label>
    <select id="role" name="role">
        <option value="user">Użytkownik</option>
        <option value="admin">Administrator</option>
    </select>
    <br>

    <button type="submit">Dodaj użytkownika</button>
</form>
