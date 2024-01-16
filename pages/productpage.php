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
		<nav class="navtop">
			<div>
				<h1>Ternakkuy</h1>
                <a href="createItem.php"><i class="fas fa-plus"></i>Jual Produk</a>
				<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Home Page</h2>
			<p>Selamat datang kembali , <?=$_SESSION['name']?> ! Terdapat <?php echo mysqli_num_rows($data)?> produk yang dapat dibeli.</p>
    
        </div>

        <div class = "container py-5">
            <h4><?php echo mysqli_num_rows($data); ?> Produk</h4>
            <?php 
                if($jumlahProduk==0){
            ?>
                <blockquote class="blockquote text-center">
                <p class="mb-0">Tidak ada produk yang tersedia !</p>
                </blockquote>
            <?php
                }else{
                    while($row_product = mysqli_fetch_assoc($data)){
                        $sqldata = "SELECT * FROM items WHERE iditem=" .$row_product["iditem"];
                        $all_product = $conn->query($sqldata);
                        while($row = mysqli_fetch_assoc($all_product)){
            ?>            
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $row["foto"]; ?>" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["namaitem"]; ?></h5>
                            <h6 class="card-title"><?php echo $row["harga"]; ?></h6>
                            <p class="card-text"><?php echo $row["desk"]; ?></p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                            <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
            <?php
                    }
                }
            }
            ?>


            <div class="card-deck">
                <div class="card">
                    <img class="card-img-top" src="../image/sapi.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="../image/sapi.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
                <div class="card">
                    <img class="card-img-top" src="../image/sapi.jpg" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
                    </div>
                </div>
            </div> 
        </div>
	</body>
</html>