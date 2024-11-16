<h1>Users</h1>
<a href="/admin/add-user-form"><button class="btn add-btn" role="button">ADD</button></a>
<div class="users-table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
                <th>Email</th>
                <th>Role</th>
                <th>Created at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['password']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td class="actions-column">
                        <a href="/admin/update-user-form/<?php echo htmlspecialchars($user['id']); ?>">
                            <button class="btn edit-btn" role="button">Edit</button>
                        </a>
                        <form action="/admin/delete-user" class="button-form" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
                            <button type="submit" class="btn delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="pagination-wrapper"><br>
            <div class="page-input-container">
                <form action="/admin/users" method="GET" class="page-input-form">
                    <input type="number" id="page" name="page" min="1" max="<?php echo $totalPages; ?>" placeholder="Enter page" required>
                    <button class="go-button" type="submit">Go</button>
                </form>
            </div>
            
            <div class="pagination">
                <!-- Poprzednia strona -->
                <?php if ($currentPage > 1): ?>
                    <a href="/admin/users?page=<?php echo $currentPage - 1; ?>" class="prev-btn">&laquo; Previous</a>
                <?php endif; ?>

                <!-- Pierwsza strona zawsze widoczna -->
                <a href="/admin/users?page=1"<?php if ($currentPage == 1) echo ' class="active"'; ?>>1</a>

                <!-- Kropki, jeśli jesteśmy na dalszych stronach niż 4 -->
                <?php if ($currentPage > 4): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>

                <!-- Strony sąsiadujące z bieżącą stroną -->
                <?php
                    $start = max(2, $currentPage - 1);
                    $end = min($totalPages - 1, $currentPage + 1);
                    for ($i = $start; $i <= $end; $i++): 
                ?>
                    <a href="/admin/users?page=<?php echo $i; ?>"<?php if ($i == $currentPage) echo ' class="active"'; ?>><?php echo $i; ?></a>
                <?php endfor; ?>

                <!-- Kropki, jeśli jesteśmy przed końcowymi stronami -->
                <?php if ($currentPage < $totalPages - 3): ?>
                    <span class="pagination-dots">...</span>
                <?php endif; ?>

                <!-- Ostatnia strona zawsze widoczna -->
                <?php if ($totalPages > 1): ?>
                    <a href="/admin/users?page=<?php echo $totalPages; ?>"<?php if ($currentPage == $totalPages) echo ' class="active"'; ?>><?php echo $totalPages; ?></a>
                <?php endif; ?>

                <!-- Następna strona -->
                <?php if ($currentPage < $totalPages): ?>
                    <a href="/admin/users?page=<?php echo $currentPage + 1; ?>" class="next-btn">Next &raquo;</a>
                <?php endif; ?>

            </div>
        </div>