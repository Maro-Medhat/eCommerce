<?php
    session_start();

    if (!(isset($_COOKIE['user_id'])) || $_COOKIE['user_id'] != 1) 
        header("Location: ../access_denied.php");

    $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");
        $id = $_GET['id'];
        $query = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $uName = $row['name'];
        $uEmail = $row['email'];
        $uMobile = $row['mobile'];
        $uPassword = $row['password'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../css/Bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="../../css/navbar.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="users.php"><i data-feather="users"></i> Show Users</a></li>
            <li><a href="add_user.php"><i data-feather="user-plus"></i> Add User</a></li>
            <li><a href="../products/add_product.php"><i data-feather="package"></i> Add Product</a></li>
            <li><a href="../products/products.php"><i data-feather="copy"></i> Show Products</a></li>
            <li><a href="../../login.php?logout=true"><i data-feather="log-out"></i> Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex p-2 mb-2 justify-content-between">
                <h2>Edit User</h2>
                <a href="users.php">
                    <i class="text-primary" data-feather="corner-down-left"></i>
                </a>
            </div>
            <hr>
            <form action="users.php" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" value="<?php echo $uName?>" name="name" class="form-control" id="name" placeholder="Ex. Maro" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" value="<?php echo $uEmail?>" name="email" class="form-control" id="email" placeholder="Ex. test@gmai.com" required>
                </div>

                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="number" value="<?php echo $uMobile?>" name="mobile" class="form-control" id="mobile" placeholder="Ex. 123456789">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Ex. 123456">
                </div>

                <input type="hidden" name="id" value="<?php echo $id?>">

                <input type="submit" class="btn btn-primary" value="Edit" name="action">
            </form>
        </div>
    </div>
</body>
<!-- Bootstrap -->
<script src="../../css/Bootstrap/bootstrap.bundle.min.js"></script>

<!-- Feather Icons -->
<script src="../../css/Feather_icons/feather.js"></script>
<script>
    feather.replace();

</script>
</html>