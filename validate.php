<?php
    session_start();
    $user_id = $_SESSION['user_id'];

    $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");
    $id = $_GET['id'];
    $query = "SELECT * FROM products WHERE id=$id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate</title>

    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/validate.css">
</head>
<body>
    <nav>
        <ul>
            <li><a href="cart.php"><i data-feather="shopping-cart"></i> Cart</a></li>
            <li><a href="profile.php"><i data-feather="user"></i> Profile</a></li>
            <li><a href="products.php"><i data-feather="copy"></i> Show Products</a></li>
            <li><a href="login.php?logout=true"><i data-feather="log-out"></i> Logout</a></li>
        </ul>
    </nav>
    <form action="cart.php" method="POST">
        <h2>Do You Really Want To Buy This Product?</h2>
        <input type="hidden" name="id" value="<?php echo $row['id']?>">
        <input type="hidden" name="name" value="<?php echo $row['name']?>">
        <input type="hidden" name="price" value="<?php echo $row['price']?>">
        <input type="submit" name="Add" value="Add To Cart">
        <a href="home.php">Back To Products Page</a>
    </form>
</body>
<!-- Feather Icons -->
<script src="css/Feather_icons/feather.js"></script>

<script>
   feather.replace();
</script>
</html>