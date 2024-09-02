<?php
$title = 'Add Product';
ob_start();
?>

<h2> Product</h2>
<form method="post" action="/products/create">
    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="name" name="name"  required>
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" class="form-control" id="price" name="price" step="0.01"  required>
    </div>
    <div class="mb-3">
        <label for="quantity" class="form-label">Quantity Available</label>
        <input type="number" class="form-control" id="quantity" name="quantity"  required>
    </div>
    <button type="submit" class="btn btn-primary">Save Product</button>
</form>

<?php
$content = ob_get_clean();
require __DIR__ . '/../layout.php';
?>
