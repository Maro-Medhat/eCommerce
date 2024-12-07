<?php
    session_start();

    if (!(isset($_COOKIE['user_id'])) || $_COOKIE['user_id'] != 1) 
        header("Location: ../access_denied.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/form.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="../users/users.php"><i data-feather="users"></i> Show Users</a></li>
            <li><a href="../users/add_user.php"><i data-feather="user-plus"></i> Add User</a></li>
            <li><a href="add_product.php"><i data-feather="package"></i> Add Product</a></li>
            <li><a href="products.php"><i data-feather="copy"></i> Show Products</a></li>
            <li><a href="../../login.php?logout=true"><i data-feather="log-out"></i> Logout</a></li>
        </ul>
    </nav>
    <div class="main">
        <h1>Add Product</h1>
        <form action="products.php" method="POST" enctype="multipart/form-data">
            <div class="input1">
                <label for="name">Name: </label>
                <input type="text" name="name" id="name" placeholder="IPhone">
            </div>

            <div class="input2">
                <label for="price">Price: </label>
                <input type="number" name="price" id="price" placeholder="$5000">
            </div>

            <div class="input3">
                <label for="image">Add Image: </label>
                <input type="file" name="image" id="image">
            </div>

            <input type="submit" name="action" value="Add">
        </form>
    </div>
</body>
<!-- Feather Icons -->
<script src="../../css/Feather_icons/feather.js"></script>

<script>
    feather.replace();
</script>
</html>