<h1>Add Quiz</h1>
<div class="form-wrapper">
    <form action="/admin/add-quiz" method="post" class="form">
        <label for="title">Quiz Title:</label>
        <input type="text" id="title" name="title" class="form-input" required>
        
        <label for="description">Quiz Description:</label>
        <textarea id="description" name="description" class="form-textarea" required></textarea>

        <button type="submit" class="form-btn">Add Quiz</button>
    </form>
</div>
