<?php

session_start();

if(!isset($_SESSION['loggedin'])){
    header('Location: ../index.html');
    exit;
}   

$dtb_host = "localhost";
$dtb_name = "ternakkuy";
$dtb_pass = "root";
$dtb_password = "";
$conn = mysqli_connect($dtb_host, $dtb_pass, $dtb_password, $dtb_name);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

$nama = $_GET['nama'];
$queryProduk = mysqli_query($conn,"SELECT * FROM items WHERE iditem='$nama'");
$produk = mysqli_fetch_array($queryProduk);


?>

<!DOCTYPE html>
<html lang="en">
<link href="../app/scss/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<style>
    form div{
        margin-bottom: 10px;
    }
</style>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creating item</title>
</head>
<body class="loggedin">
<header class="header">
      <div class="overlay has-fade"></div>
      <nav class="container container--pall flex flex-jc-sb flex-ai-c">
        <a href="index.html" class="header__logo">
          <img src="../image/Ternakkuy.png" alt="Ternakkuy" /> 
        </a>

        <a id="btnHamburger" href="#" class="header__toggle hide-for-desktop">
          <span></span>
          <span></span>
          <span></span>
        </a>

        <div class="header__links hide-for-mobile">
        <a href="productpage.php"><i class="fas fa-arrow-left"></i>  Home</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i>  Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>    Logout</a>
        </div>

      </nav>

      <div class="header__menu has-fade">
      <a href="productpage.php"><i class="fas fa-arrow-left"></i> Home</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
</header>
</body>
<body>
<div class = "container-fluid py-5">
    <div class="content">
        <h2>Detail produk</h2>  
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="../image/<?php echo $produk['foto']; ?>" class="w-100" alt="">
            </div>
            <div class="col-md-6 offset-md-1">
                <h1><?php echo $produk['nama'] ?></h1> <br>
                <p class ="fs-5">
                    <?php echo $produk['desk'] ?>
                </p>
                <h4>
                    Rp. <?php echo $produk['harga'] ?>
                </h4> <br>
                <h6>
                    Kontak penjual : 
                </h6>
            </div>
    </div>


</div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="../app/js/script.js"></script>
</body>