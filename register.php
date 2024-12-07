<?php

$conn = mysqli_connect("localhost", "root", "rootroot", "ecommerce");
if(isset($_POST['submit'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   $pass = md5($_POST['password']);
   $cpass = md5($_POST['cpassword']);
   $image = $_FILES['image']['name'];
   $image_folder = 'proiles_Images/'.$image;

   $query = "SELECT * FROM users WHERE email = '$email' AND password = '$pass'";
   $select = mysqli_query($conn, $query);

   if(mysqli_num_rows($select) > 0)
      $toastr = 1;
   else{
      if($pass != $cpass)
         $toastr = 2;

      else{
         $query = "INSERT INTO users(name, email, password, image) VALUES('$name', '$email', '$pass', '$image')";
         mysqli_query($conn, $query);
         move_uploaded_file($_FILES['image']['tmp_name'], $image_folder);
         header('location: login.php');
      }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/login&register.css">

   <!-- Toastr -->
   <link rel="stylesheet" href="css/Toastr/toastr.css">

</head>
<body>
   
<div class="form-container">

   <form action="register.php" method="POST" enctype="multipart/form-data">
      <h3>Register Now</h3>
      <input type="text" name="name" placeholder="Ex. Maro" class="box" required>
      <input type="email" name="email" placeholder="Ex. test@test.com" class="box" required>
      <input type="password" name="password" placeholder="*********" class="box" required>
      <input type="password" name="cpassword" placeholder="*********" class="box" required>
      <input type="file" name="image" class="box">
      <input type="submit" name="submit" value="Register" class="btn">
      <p>already have an account? <a href="login.php">LOGIN NOW!!</a></p>
   </form>

</div>
<!-- jquery -->
<script src="js/jquery.js"></script>

<!-- toastr -->
<script src="js/toastr.js"></script>


<script>
    /* Toastr Message */
    <?php if(isset($toastr)){
        switch($toastr) {
            case 1:
                ?> toastr.error("User Already Exists!!"); <?php
                break;
    
            case 2:
                ?> toastr.error("Password Doesn't Match!!"); <?php
                break;
        }}?>
</script>
</body>
</html>