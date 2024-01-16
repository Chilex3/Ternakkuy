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

$id = $_GET['p'];

/* mengambil isi tabel item */
$query = mysqli_query($conn,"SELECT a.*, b.nama AS nama_kategori FROM items a JOIN kategori b ON a.
idkategori=b.idkategori WHERE a.iditem='$id'");
$data = mysqli_fetch_array($query);

/* mengambil isi tabel kategori */
$queryKategori = mysqli_query($conn,"SELECT * FROM kategori WHERE idkategori!='$data[idkategori]'");

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
<body class="loggedin"><header class="header">
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
        <a href="productpage.php"><i class="fas fa-arrow-left"></i> Home</a>
        <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

      </nav>

      <div class="header__menu has-fade">
        <a href="productpage.php"><i class="fas fa-arrow-left"></i> Home</a>
        <a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
      </div>
</header>
    <div class="content">
        <h2>Edit detail produk</h2>
    </div>

    <div class = "container py-5">
    <form action="" method="post" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Foto Produk    </label>
                <img src="../image/<?php echo $data['foto'] ?>" alt="" width="300px"> 
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <br>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Nama produk</label>
                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" value="<?php echo $data['nama'] ?>" required>
            </div>
            <div class="input-group mb-3">
                <label class="input-group-text" for="inputGroupFile01">Kategori produk</label>
                <select name="idkategori" id="idkategori" class="form-control" required>
                    <option value="<?php echo $data['idkategori']?>"><?php echo $data['nama_kategori']?></option>
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
                <input type="number" name="harga" class="form-control" value="<?php echo $data['harga']?>" required>
            </div>
            <div class="input-group mb-3">
            <label class="input-group-text" for="inputGroupFile01">Deskripsi</label>
                <textarea type="desk" name="desk" cols="30" row="10" class="form-control"><?php echo $data['desk']?></textarea>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
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
                    $queryUpdate = mysqli_query($conn, "UPDATE items SET idkategori='$kategori',
                    nama = '$nama', harga = '$harga', desk = '$desk' WHERE iditem=$id");

                    if ($nama_file !== '') {
                        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'gif' && $imageFileType != 'jpeg') {
                    ?>
                            <div class="alert alert-warning mt-3" role="alert">
                                File harus bertipe jpg, png, dan gif
                            </div>
                    <?php
                        } else {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                            $queryUpdate = mysqli_query($conn, "UPDATE items SET foto='$new_name' WHERE iditem='$id'");
                            
                            if($queryUpdate){
                    ?>
                                <div class="alert alert-primary mt-3" role="alert">
                                    Edit Produk Berhasil disimpan
                                </div>

                                <meta http-equiv="refresh" content="2"; url="produkDetail.php"/>
                    <?php
                            }
                        }
                    }
                }
            }

            if(isset($_POST['hapus'])){
                $queryHapus = mysqli_query($conn, "DELETE FROM items WHERE iditem='$id'");

                if($queryHapus){
                    ?>
                    <div class="alert alert-primary mt-3" role="alert">
                            Produk Berhasil dihapus
                    </div>
                    
                    <meta http-equiv="refresh" content="2; url=productpage.php"/>
                    <?php
                }
            }
        
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="../app/js/script.js"></script>
</body>