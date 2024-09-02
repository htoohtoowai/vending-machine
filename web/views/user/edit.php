<?php
$title = 'Edit User';
ob_start();
?>

<h2>Edit User</h2>
<form method="post" action="/users/<?php echo $user['id']; ?>/update">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password (leave empty to keep current)</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="admin" <?php echo ($user['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
            <option value="user" <?php echo ($user['role'] === 'user') ? 'selected' : ''; ?>>User</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update User</button>
</form>

<?php
$content = ob_get_clean();
require 'views/layout.php';
?>
