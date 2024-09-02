<?php
$title = 'Edit Transaction';
ob_start();
?>

<h2>Edit Transaction</h2>
<form method="post" action="/transactions/<?php echo $transaction['id']; ?>/update">
    <div class="mb-3">
        <label for="user_id" class="form-label">User</label>
        <select class="form-control" id="user_id" name="user_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user['id']); ?>" <?php echo ($transaction['user_id'] == $user['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($user['username']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="product_id" class="form-label">Product</label>
        <select class="form-control" id="product_id" name="product_id" required>
            <?php foreach ($products as $product): ?>
                <option value="<?php echo htmlspecialchars($product['id']); ?>" <?php echo ($transaction['product_id'] == $product['id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($product['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity</label>
        <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="<?php echo htmlspecialchars($transaction['quantity']); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Transaction</button>
</form>

<?php
$content = ob_get_clean();
require 'views/layout.php';
?>
