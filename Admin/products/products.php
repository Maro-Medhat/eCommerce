<?php
    session_start();
    $user_id = $_SESSION['user_id'];

    if (!(isset($_COOKIE['user_id'])) || $_COOKIE['user_id'] != 1) 
        header("Location: ../access_denied.php");

    $conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");
    if(isset($_POST['action'])){
        if($_POST['action'] == "Add"){
            $pName = $_POST['name'];
            $pPrice = $_POST['price'];
            $pImage_Name = $_FILES["image"]["name"];
            $pImage_Target_File = "../../products_Images/" . $pImage_Name;
            $uploadFlag = (file_exists($pImage_Target_File));
            $toastr = ($uploadFlag == 1 ? 0 : 1);
                
            if($uploadFlag == 0){
                $query = "INSERT INTO products(name, price, image) VALUES ('$pName', '$pPrice', '$pImage_Name')";
                $result = mysqli_query($conn, $query); 
                move_uploaded_file($_FILES["image"]["tmp_name"], $pImage_Target_File);  
            }
        }

        else if($_POST['action'] == "Edit"){
            $toastr = 2;
            $id = $_POST['id'];
            $pName = $_POST['name'];
            $pPrice = $_POST['price'];
            $pImage_Name = $_FILES["image"]["name"];
            $pImage_Target_File = "../../products_Images/" . $pImage_Name;

            if (!(file_exists($pImage_Target_File)))
                move_uploaded_file($_FILES["image"]["tmp_name"], $pImage_Target_File);


            /* Delete Old Image */
            $query = "SELECT image FROM products WHERE id=$id";
            $result = mysqli_query($conn, $query);
            system("del ..\\products_Images\\" . mysqli_fetch_assoc($result)['image']);

            $query = "UPDATE products SET name='$pName', price='$pPrice', image='$pImage_Name' Where id=$id";
            $result = mysqli_query($conn, $query);
        }

    }
    if(isset($_GET['id']) && $_GET['action'] == "Delete"){
        $toastr = 3;
        $id = $_GET['id'];

        /* Delete From Products_Images Folder */
        $query = "SELECT image FROM products WHERE id=$id";
        $result = mysqli_query($conn, $query);
        $image_name = mysqli_fetch_assoc($result)['image'];
        system("del ..\\products_Images\\$image_name");

        /* Delete From Database */
        $query = "DELETE FROM products WHERE id=$id";
        $result = mysqli_query($conn, $query);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/products.css">
    <link rel="stylesheet" href="../../css/Toastr/toastr.css">
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
    <div class="container">
        <h1>Our Products</h1>
        <div class="products-grid">
            <?php
            $query = "SELECT * FROM products";
            $result = mysqli_query($conn, $query);

            while($row = mysqli_fetch_assoc($result)){ ?>
                <div class="product-card">
                    <img src="<?php echo  "../../products_Images/" . $row['image']?>" alt="Product Image" class="product-image">
                    <div class="product-name"><?php echo $row['name']?></div>
                    <div class="product-price">$<?php echo $row['price']?></div>
                    <div class="buttons">
                        <a href="products.php?id=<?php echo $row['id']?>&action=Delete" class="delete-button"><i class="text-light " data-feather="trash-2"></i></a>
                        <a href="edit_product.php?id=<?php echo $row['id']?>" class="edit-button"><i class="text-light" data-feather="edit"></i></a> 
                    </div>
                </div>
            <?php }?>  
        </div>
    </div>
</body>
<!-- jquery -->
<script src="../../js/jquery.js"></script>

<!-- toastr -->
<script src="../../js/toastr.js"></script>

<!-- Feather Icons -->
<script src="../../css/Feather_icons/feather.js"></script>

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