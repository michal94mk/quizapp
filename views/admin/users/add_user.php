<h1>Dodaj Użytkownika</h1>
<div class="form-wrapper">
    <form class="form" action="/admin/add-user" method="POST">
        <label for="username">Nazwa użytkownika:</label>
        <input type="text" id="username" name="username" class="form-input" required>

        <label for="password">Hasło:</label>
        <input type="text" id="password" name="password" class="form-input" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" class="form-input" required>

        <label for="role">Rola:</label>
        <select id="role" name="role" class="form-input">
            <option value="user">Użytkownik</option>
            <option value="admin">Administrator</option>
        </select>

        <button type="submit" class="form-btn">Dodaj użytkownika</button>
    </form>
</div>
