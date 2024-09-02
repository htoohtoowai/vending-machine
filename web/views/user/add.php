<?php
$title = 'Add User';
ob_start();
?>

<h2>Add User</h2>
<form method="post" action="/users/create">
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="" disabled selected>Select a role</option>
            <option value="admin">Admin</option>
            <option value="user">User</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save User</button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
