<h1>Edit User</h1>
    <form action="/admin/update-quiz" method="post">
        <input type="hidden" name="id" value="<?php echo $result['id']; ?>">
        <label for="name">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo $result['title']; ?>"><br><br>
        <label for="email">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $result['description']; ?>"><br><br>
        <input type="submit" value="Update">
    </form>