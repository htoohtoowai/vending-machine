<?php
$title = 'Transaction List';
ob_start();
?>

<h2>Transaction List</h2>
<?php
if (isset($_SESSION['success_message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
    // Clear the message after displaying it
    unset($_SESSION['success_message']);
}
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Total Price</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?php echo htmlspecialchars($transaction['id']); ?></td>
                <td><?php echo htmlspecialchars($transaction['username']); ?></td>
                <td><?php echo htmlspecialchars($transaction['product_name']); ?></td>
                <td><?php echo htmlspecialchars($transaction['quantity']); ?></td>
                <td><?php echo htmlspecialchars($transaction['total_price']); ?></td>
                <td>
                    <a href="/transactions/<?php echo $transaction['id']; ?>/edit" class="btn btn-warning btn-sm">Edit</a>
                    <form method="post" action="/transactions/<?php echo $transaction['id']; ?>/delete" style="display:inline;">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Pagination controls -->
<nav aria-label="Page navigation">
    <ul class="pagination">
        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
            <a class="page-link" href="/transactions?page=<?php echo $page - 1; ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                <a class="page-link" href="/transactions?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
            <a class="page-link" href="/transactions?page=<?php echo $page + 1; ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
</nav>

<?php
$content = ob_get_clean();
require 'views/layout.php';
?>
