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
	<nav class="navtop">
		<div>	
            <h1>Ternakkuy</h1>
            <a href="productpage.php"><i class="fas fa-arrow-left"></i>Home</a>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
		</div>
	</nav>
    <div class="content">
        <h2>Menambahkan produk</h2>
    </div>

    <div class = "container py-5">
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="nama">Nama produk</label>
                <input type="text" id="nama" name="nama" class="form-control" autocomplete="off" required>
            </div>
            <div>
                <label for="idkategori">Kategori produk</label>
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
            <div>
                <label for="Harga">Harga</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <div>
                <label for="foto">Foto</label>
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div>
                <label for="desk">Deskripsi</label>
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



                if($nama == '' || $kategori= '' || $harga= ''){
        ?>
                    <div class="alert alert-warning mt-3" role="alert">
                        Nama, kategori dan harga harus diisi!
                    </div>
        <?php
                }else{
                    if ($nama_file!=''){
                        if($imageFileType !='jpg' && $imageFileType !='png' && $imageFileType != 'gif' && $imageFileType != 'jpeg'){
        ?>
                        <div class="alert alert-warning mt-3" role="alert">
                            File harus bertipe jpg, png dan gif
                        </div>
        <?php
                        }else{
                            move_uploaded_file($_FILES["foto"]["tmp_name"], $target_dir . $new_name);
                        }
                    }
                    
                    echo "Selected idkategori: " . $_POST['idkategori'];

                    // query insert ke table items
                    $queryTambah = mysqli_query($conn, "INSERT INTO items (nama, idkategori, harga, foto, desk)
                    VALUES ('$nama', '$kategori', '$harga', '$new_name', '$desk')");
                    
                    if($queryTambah){
        ?>          
                    <div class = "alert alert-primary mt-3" role="alert">
                        Produk Berhasil disimpan
                    </div>
        <?php           
                    }else{
                        echo mysqli_error($conn);
                    }
                }
            }
        ?>

    </div>
</body>