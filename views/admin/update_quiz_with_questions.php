    <h1>Edit Quiz</h1>
    <form action="/admin/update-quiz" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['id']); ?>">

        <label for="title">Quiz Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($quiz['title']); ?>"><br><br>

        <label for="description">Quiz Description:</label>
        <textarea id="description" name="description"><?php echo htmlspecialchars($quiz['description']); ?></textarea><br><br>
        <button type="submit">Update Quiz</button>
    </form>
