<?php
$title = 'Edit Product';
ob_start();
?>

<h2>Edit Product</h2>
<form method="post" action="/products/<?php echo $product['id']; ?>/update">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity Available</label>
        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity_available']); ?>" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Product</button>
</form>

<?php
$content = ob_get_clean();
require 'views/layout.php';
?>
