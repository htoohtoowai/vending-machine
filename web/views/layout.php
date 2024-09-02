<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Vending Machine'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/admin/dashboard">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/products">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/products/create">Add Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/users/create">Add User</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transactions">Transactions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/transactions/create">Add Transaction</a>
                    </li>
                </ul>
                <!-- Logout Button -->
                <form class="d-flex ms-auto" method="POST" action="/admin/logout">
                    <button class="btn btn-outline-danger" type="submit">Logout</button>
                </form>
            </div>
            
        </div>
    </nav>

    <div class="container mt-5">
        <?php echo $content; ?>
    </div>

    <footer class="bg-light text-center text-lg-start mt-auto py-3">
        <div class="container">
            <span class="text-muted">&copy; 2024 Vending Machine System</span>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
