<h1>Edit Quiz</h1>
<div class="form-wrapper">
    <form class="form" action="/admin/update-quiz" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($quiz['id']); ?>">

        <label for="title">Quiz Title:</label>
        <input type="text" id="title" name="title" class="form-input" value="<?php echo htmlspecialchars($quiz['title']); ?>" required>

        <label for="description">Quiz Description:</label>
        <textarea id="description" name="description" class="form-input" required><?php echo htmlspecialchars($quiz['description']); ?></textarea>

        <button type="submit" class="form-btn">Update Quiz</button>
    </form>
</div>
