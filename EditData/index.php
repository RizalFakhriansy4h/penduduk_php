<?php 
require '../DatabaseConn/DatabaseConn.php';

$id = $_GET["id"];


// ============================
// data yang mau diedit kembalikan value
$profil = query("SELECT * FROM profil WHERE id = $id")[0];
$namaProvinsi = query("SELECT pv.* FROM profil pr JOIN kode_provinsi pv ON pv.id_provinsi = LEFT(pr.nik, 2) WHERE pr.id = $id")[0];
$namaPekerjaan = query("SELECT pk.* FROM profil pr JOIN kode_pekerjaan pk ON pk.id_pekerjaan = LEFT(RIGHT(pr.nik, 2), 2) WHERE pr.id = $id")[0];
$namaAgama = query("SELECT agm.* FROM profil pr JOIN kode_agama agm ON agm.id_agama = LEFT(RIGHT(pr.nik, 4), 2) WHERE pr.id = $id")[0];

// ======================
$agamas = query("SELECT * FROM kode_agama");
$provinsis = query("SELECT * FROM kode_provinsi");
$pekerjaans = query("SELECT * FROM kode_pekerjaan ORDER BY nama_pekerjaan");
$status = query("SELECT status FROM profil GROUP BY status;");

// ==========================
$tanggal = substr($profil["nik"], 2, 8);
$tahun = substr($tanggal, 4, 4);
$bulan = substr($tanggal, 2, 2);
$tanggal = substr($tanggal, 0, 2);
$tanggal_format = $tahun . '-' . $bulan . '-' . $tanggal;

function editData($post){
	global $conn;

    // Ambil data dari setiap form 
	$id = $post["idPenduduk"];
    $nama = htmlspecialchars($post["nama"]);
    $email = htmlspecialchars($post["email"]);
    $alamat = htmlspecialchars($post["alamat"]);
    $status = htmlspecialchars($post["status"]);

    $nikProvinsi = htmlspecialchars($post["nikProvinsi"]);
    $nikPekerjaan = htmlspecialchars($post["nikPekerjaan"]);
    $nikAgama = htmlspecialchars($post["nikAgama"]);
    $inputTanggalLahir = htmlspecialchars($post["nikTanggalLahir"]);

    // Hitung umur
    $tanggal_lahir_obj = new DateTime($inputTanggalLahir);
    $tanggal_hari_ini_obj = new DateTime();
    $umur = $tanggal_lahir_obj->diff($tanggal_hari_ini_obj)->y;

    // Buat NIK
    $nikTanggalLahir = date('dmY', strtotime($inputTanggalLahir));
    $nik = $nikProvinsi . $nikTanggalLahir . $nikAgama . $nikPekerjaan;
	// kirim data yang sudah di ubah ke database
	$query= "UPDATE profil SET nik ='$nik',nama ='$nama',alamat='$alamat',status ='$status',umur ='$umur',email ='$email' WHERE id = $id ";
	
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);

}

if ( isset($_POST["edit"]) ) {
	
	// cek apakah data berhasil ditambah atau tidak
	if (editData($_POST) > 0 ){
				echo "
			<script>
				alert('data berhasil diubah!');
				document.location.href=
				'../';
			</script>
			";	
			}	
	else { echo "
			<script>
					alert('data gagal diubah!');
					document.location.href=
					'../index.php';
			</script>
			";
			}

}



?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Halaman Edit Data</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md6">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="../">CI DATA PENDUDUK</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="../">Penduduk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="../AddData/">Tambah Data</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>


<div class="container">
    <div class="row mt-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <strong>EDIT DATA PENDUDUK</strong>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="idPenduduk" value="<?= $profil["id"] ?>">

                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" id="nama" name="nama" class="form-control mb-3" required value="<?= $profil["nama"] ?>">

                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control mb- 3" required value="<?= $profil["email"] ?>">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nikProvinsi" class="form-label">Provinsi</label>
                                <select class="form-select" id="nikProvinsi" name="nikProvinsi">
                                <?php foreach($provinsis as $provinsi): ?>
                                        <?php if($namaProvinsi["nama_provinsi"] === $provinsi["nama_provinsi"]): ?>
                                            <option value="<?= $provinsi["id_provinsi"] ?>" selected><?= $provinsi["nama_provinsi"] ?></option>
                                        <?php else : ?>
                                            <option value="<?= $provinsi["id_provinsi"] ?>"><?= $provinsi["nama_provinsi"] ?></option>
                                        <?php endif; ?>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="nikTanggalLahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" id="nikTanggalLahir" name="nikTanggalLahir" class="form-control" min="1970-01-01" max="2002-12-31" value="<?= $tanggal_format; ?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nikPekerjaan" class="form-label">Pekerjaan</label>
                                <select class="form-select" id="nikPekerjaan" name="nikPekerjaan">
                                <?php foreach($pekerjaans as $pekerjaan): ?>
                                        <?php if($namaPekerjaan["nama_pekerjaan"] === $pekerjaan["nama_pekerjaan"]): ?>
                                            <option value="<?= $pekerjaan["id_pekerjaan"] ?>" selected><?= $pekerjaan["nama_pekerjaan"] ?></option>
                                        <?php else : ?>
                                            <option value="<?= $pekerjaan["id_pekerjaan"] ?>"><?= $pekerjaan["nama_pekerjaan"] ?></option>
                                        <?php endif; ?>
                                <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="nikAgama" class="form-label">Agama</label>
                                <select class="form-select" id="nikAgama" name="nikAgama">
                                <?php foreach($agamas as $agama): ?>
                                        <?php if($namaAgama["nama_agama"] === $agama["nama_agama"]): ?>
                                            <option value="<?= $agama["id_agama"] ?>" selected><?= $agama["nama_agama"] ?></option>
                                        <?php else : ?>
                                            <option value="<?= $agama["id_agama"] ?>"><?= $agama["nama_agama"] ?></option>
                                        <?php endif; ?>
                                <?php endforeach; ?>
                                </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <?php foreach($status as $statu): ?>
                                            <?php if($profil["status"] === $statu["status"]): ?>
                                                <option value="<?= $statu["status"] ?>" selected><?= $statu["status"] ?></option>
                                            <?php else : ?>
                                                <option value="<?= $statu["status"] ?>"><?= $statu["status"] ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" name="alamat" id="alamat" rows="3" required><?= $profil["alamat"] ?></textarea>
                        </div>

                        <button type="submit" name="edit" class="btn btn-primary btn-lg">Edit Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    






    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>