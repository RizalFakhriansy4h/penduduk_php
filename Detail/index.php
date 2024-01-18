<?php 
require '../DatabaseConn/DatabaseConn.php';
// ambil id yang ada di url
$id = $_GET["id"];

// data yang mau diedit kembalikan value
$profil = query("SELECT * FROM profil WHERE id = $id")[0];
$namaProvinsi = query("SELECT pv.* FROM profil pr JOIN kode_provinsi pv ON pv.id_provinsi = LEFT(pr.nik, 2) WHERE pr.id = $id")[0];
$namaPekerjaan = query("SELECT pk.* FROM profil pr JOIN kode_pekerjaan pk ON pk.id_pekerjaan = LEFT(RIGHT(pr.nik, 2), 2) WHERE pr.id = $id")[0];
$namaAgama = query("SELECT agm.* FROM profil pr JOIN kode_agama agm ON agm.id_agama = LEFT(RIGHT(pr.nik, 4), 2) WHERE pr.id = $id")[0];



?>




<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Halaman Detail Penduduk</title>
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


    <div class="container ">
        <div class="row">
            <div class="col-md-5">
            
            <div class="card mt-3" style="width: 20rem;">
                
                <div class="card-header">
                    <h3 class="card-title">DETAIL PENDUDUK</h3>
                </div>

                <div class="card-body">
                    <h5 class="card-title"><?= $profil["nama"] ?></h5>
                    <p class="card-text text-primary"><?= $profil["email"] ?></p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Asal : <?= $namaProvinsi["nama_provinsi"] ?></li>
                    <li class="list-group-item">Pekerjaan : <?= $namaPekerjaan["nama_pekerjaan"] ?></li>
                    <li class="list-group-item">Agama :<?= $namaAgama["nama_agama"] ?></li>
                    <li class="list-group-item">Alamat : <?= $profil["alamat"] ?></li>
                    <li class="list-group-item">Umur : <?= $profil["umur"] ?> Tahun</li>
                    <li class="list-group-item">Status : <?= $profil["status"] ?></li>
                </ul>
                <a href="../" class="btn btn-primary">Back</a>
            </div>
            </div>
        </div>
    </div>


    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>