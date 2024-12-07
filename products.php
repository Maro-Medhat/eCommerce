<?php
    session_start();
    $user_id = $_SESSION['user_id'];
    
    $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/products.css">
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
    <div class="container">
        <h1>Our Products</h1>
        <div class="products-grid">
            <?php
            $query = "SELECT * FROM products";
            $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_assoc($result)){ ?>
                <div class="product-card">
                    <img src="<?php echo  "products_Images/" . $row['image']?>" alt="Product Image" class="product-image">
                    <div class="product-name"><?php echo $row['name']?></div>
                    <div class="product-price">$<?php echo $row['price']?></div>
                    <div class="buttons">
                        <a href="validate.php?id=<?php echo $row['id']?>" class="edit-button"><i data-feather="shopping-cart"></i> Add To Cart</a> 
                    </div>
                </div>
            <?php }?>  
        </div>
    </div>
</body>
<!-- jquery -->
<script src="js/jquery.js"></script>

<!-- toastr -->
<script src="js/toastr.js"></script>

<!-- Feather Icons -->
<script src="css/Feather_icons/feather.js"></script>

<script>
    feather.replace();

    /* Toastr Message */
    <?php if(isset($toastr)){
        switch($toastr) {
            case 0:
                ?> toastr.error("Product Already Exists!!"); <?php
                break;
    
            case 1:
                ?> toastr.success("Product Added Successfully!!"); <?php
                break;
    
            case 2:
                ?> toastr.success("Product Edited Successfully!!"); <?php
                break;
            
            case 3:
                ?> toastr.error("Product Deleted Successfully!!"); <?php
                break;
        }}?>
</script>
</html>