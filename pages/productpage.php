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

/* mencari tahu apakah tabel item berisi atau tidak */
$query = mysqli_query($conn,"SELECT * FROM items");
$jumlahProduk = mysqli_num_rows($query);

/* mengambil isi tabel item */
$sql = "SELECT * FROM items";
$data = $conn->query($sql);

/* mengambil isi tabel kategori */
$queryKategori = mysqli_query($conn, "SELECT * FROM kategori");


/*if(isset($_GET['kategori'])){
    $queryGetKategoriId = mysqli_query($conn, "SELECT idkategori FROM kategori WHERE nama='$_GET[kategori]'");
    $kategoriId = mysqli_fetch_array($queryGetKategoriId);

    $queryProduk = mysqli_query($conn, "SELECT * FROM items WHERE idkategori='$kategoriId[idkategori]'");
}else{
    $que
}*/

?>

<!DOCTYPE html>
<html lang="en">
<link href="../app/scss/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body class="loggedin">

<header class="header">
      <div class="overlay has-fade"></div>
      <nav class="container container--pall flex flex-jc-sb flex-ai-c">
        <a href="productpage.php" class="header__logo">
          <img src="../image/Ternakkuy.png" alt="Ternakkuy" /> 
        </a>

        <a id="btnHamburger" href="#" class="header__toggle hide-for-desktop">
          <span></span>
          <span></span>
          <span></span>
        </a>

        <div class="header__links hide-for-mobile">
        <a href="createItem.php"><i class="fas fa-plus"></i> Jual Produk</a>
        <a href="edukasi.html"><i class="fa-solid fa-book"></i> Edukasi</a>
        <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

      </nav>

      <div class="header__menu has-fade">
        <a href="createItem.php"><i class="fas fa-plus"></i> Jual Produk</a>
        <a href="edukasi.html"><i class="fa-solid fa-book"></i> Edukasi</a>
        <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
</header>
        
        <div class = "container py-5">
		<div>
			<h2>Home Page</h2>
			<p>Selamat datang kembali , <?=$_SESSION['name']?> ! Terdapat <?php echo mysqli_num_rows($data)?> produk yang dapat dibeli.</p>
        </div> <br>
        <!--
        <ul class="list-group list-group-horizontal">
            <?php while($kategori = mysqli_fetch_array($queryKategori)){ ?>
            <a href="poductpage.php?kategori=<?php echo $kategori['nama'];?>">
                <li class="list-group-item"><?php echo $kategori['nama'];?></li>
            </a>
            <?php } ?>
        </ul>
            -->
<br>    
            <h4><?php echo mysqli_num_rows($data); ?> Produk Tersedia</h4>
            <?php 
                if($jumlahProduk==0){
            ?>
                <blockquote class="blockquote text-center">
                <p class="mb-0">Tidak ada produk yang tersedia !</p>
                </blockquote>
                
            <?php
                }else{ ?>
                    <br>
                    <div class="row">
            <?php
                    while($row_product = mysqli_fetch_assoc($data)){
                        $sqldata = "SELECT * FROM items WHERE iditem=" .$row_product["iditem"];
                        $all_product = $conn->query($sqldata);
                        while($row = mysqli_fetch_assoc($all_product)){
            ?>      
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img class="card-img-top" src=" ../image/<?php echo $row["foto"]; ?>" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["nama"]; ?></h5>
                                <h6 class="card-title">Rp <?php echo $row["harga"]; ?></h6>
                                <p class="card-text"><?php echo $row["desk"]; ?></p>
                                <a href="produkInfo.php?nama=<?php echo $row['iditem']?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>

            <?php
                    }
                } ?>

                </div>
            <?php
            }
            ?>
            
            

        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="../app/js/script.js"></script>
	</body>
</html>