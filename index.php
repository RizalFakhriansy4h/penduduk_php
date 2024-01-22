<?php 
require 'DatabaseConn/DatabaseConn.php';

$penduduks = query("SELECT * FROM profil");
// $hasil = query("SELECT COUNT(*) AS total FROM profil");
$jumlah_penduduk = count($penduduks);
// tombol cari
function cariData($keyword){
  
    $query= "SELECT * FROM profil WHERE
  
        nama LIKE '%$keyword%' OR
        email LIKE '%$keyword%'
         
      ";
  
  return query($query);
}

// mengecek ketika tombol cari sudah ditekan
if (isset($_GET["cari"])) {
    
    $penduduks = cariData($_GET["keyword"]);
    $jumlah_penduduk = count($penduduks);
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
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <title>Halaman Penduduk</title>
  </head>
  <body>
    <div class="container">
        <div class="row">
            <div class="col-md6">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="">CI DATA PENDUDUK</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="">Penduduk</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="AddData/">Tambah Data</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="row col-md-4">
    </div>
    <h3 class="mt-3" >TABEL PENDUDUK</h3>
    <div class="row">
            <div class="col-md-4 border border-warning">
                <!-- <form action="" method="get">
                    <div class="input-group mb-6">
                        <input type="text" class="form-control" placeholder="Cari Nama/Email.." name="keyword" autocomplete="off">
                        <div class="input-group-append">
                            <button class="btn btn-primary" name="cari">Cari</button>
                        </div>
                    </div>
                </form> -->
                <h4>Aturan NIK : <span class="text-primary">07</span>30061998<span class="text-danger">03</span><span class="text-success">41</span></h4>
                <p class="text-primary">Aa : Kode Provinsi</p>
                <p>Aa : Kode Tanggal Lahir (DD/MM/YYYY)</p>
                <p class="text-danger">Aa : Kode Agama</p>
                <p class="text-success">Aa : Kode Pekerjaan</p>
            </div>
    </div>
        
    <div class="row mt-3">
        <div class="col-md">
            <!-- <h5>Hasil : <?= $jumlah_penduduk ?></h5> -->
            <table class="table table-hover" id="example">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                        <?php $i=0; foreach($penduduks as $penduduk): ?>
                            <tr>
                                <th scope="row"><?= ++$i ?></th>
                                <th scope="row"><?= $penduduk["nik"] ?></th>
                                <td><?= $penduduk["nama"] ?></td>
                                <td><?= $penduduk["email"] ?></td>
                                <td>
                                    <a href="Detail/?id=<?= $penduduk["id"] ?>"><span class="badge bg-success text-light">Detail</span></a>
                                    <a href="EditData/?id=<?= $penduduk["id"] ?>"><span class="badge bg-warning text-light">Edit</span></a>
                                    <a href="Delete/?id=<?= $penduduk["id"] ?>" class="tombol-hapus"><span class="badge bg-danger text-light" onclick="return confirm('Yakin hapus ?')">Hapus</span></a>
                                </td>
                            </tr>
                        <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>





    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script>
        new DataTable('#example');
    </script>
</body>
</html>