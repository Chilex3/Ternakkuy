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
$queryKategori = mysqli_query($conn,"SELECT * FROM kategori");

function generateRandomString($length=10){
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString ='';
    for ($i = 0; $i < $length; $i++){
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

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
<div class = "container py-5">
    <div class="content">
        <h2>Menambahkan produk</h2>
    </div>

    
        <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Nama produk</label>
                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Kategori produk</label>
                <select name="idkategori" id="idkategori" class="form-control" required>
                    <option value="">---Pilih satu---</option>
                    <?php
                        while($tipeKategori=mysqli_fetch_array($queryKategori)){
                    ?>
                        <option value="<?php echo $tipeKategori['idkategori']; ?>"> <?php echo $tipeKategori['nama']; ?> </option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Deskripsi</label>
                <textarea type="desk" name="desk" cols="30" row="10" class="form-control"></textarea>
            </div>
            <div>
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
            </div>
        </form>

        <?php
            if(isset($_POST['simpan'])){
                $nama = htmlspecialchars($_POST['nama']);
                $kategori = htmlspecialchars($_POST['idkategori']);
                $harga = htmlspecialchars($_POST['harga']);
                $desk = htmlspecialchars($_POST['desk']);
        
                $target_dir = "../image/";
                $nama_file = basename($_FILES["foto"]["name"]);
                $target_file = $target_dir . $nama_file;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                $imageSize = $_FILES["foto"]["size"];
        
                $randomName = generateRandomString(20);
                $new_name = $randomName . "." . $imageFileType;
        
                $kategori = isset($_POST['idkategori']) ? htmlspecialchars($_POST['idkategori']) : '';
        
                if ($nama == '' || $kategori == '' || $harga == '') {
        ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, kategori, dan harga harus diisi!
                    </div>
        <?php
                } else {
                    if ($nama_file !== '') {
                        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'jpeg') {
        ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File harus bertipe jpg, png, dan gif
                            </div>
        <?php
                        } else {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                        }
                    }
        
                    // query insert ke table items
                    $queryTambah = mysqli_query($conn, "INSERT INTO items (nama, idkategori, harga, foto, desk)
                    VALUES ('$nama', '$kategori', '$harga', '$new_name', '$desk')");
        
                    if($queryTambah) {
        ?>
                        <div class="alert alert-primary mt-3" role="alert">
                            Produk Berhasil disimpan
                        </div>
                        <meta http-equiv="refresh" content="2; url=createItem.php"/>
        <?php
                    } else {
                        echo mysqli_error($conn);
                    }
                }
            }
        ?>
            <br><br>
            <div class="content">
                <h2><?php echo mysqli_num_rows($data); ?> Produk Yang Anda Jual</h2>
            </div>
            <?php 
                if($jumlahProduk==0){
            ?>
                <blockquote class="blockquote text-center">
                <p class="mb-0">Tidak ada produk yang dijual !</p>
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
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src=" ../image/<?php echo $row["foto"]; ?>" alt="asdasd">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["nama"]; ?></h5>
                                <h6 class="card-title">Rp <?php echo $row["harga"]; ?></h6>
                                <p class="card-text"><?php echo $row["desk"]; ?></p>
                                <a href="produkDetail.php?p=<?php echo $row['iditem']?>" class="btn btn-primary">Edit</a>
                                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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