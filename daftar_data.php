<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<?php 
include "koneksi.php";

$query = "SELECT * FROM pendaftaran";
$ambil = mysqli_query($konek,$query);
$ex = mysqli_query($konek,"SELECT sum(jumlah_jam) as total_jam FROM pendaftaran");
$r = mysqli_fetch_assoc($ex);
 ?>
<div class="card mr-5 ml-5 mb-2 mt-5">
    <div class="card-body">
        <span class="h1">Ekoji Academy</span>
        <a href="index.php" class="btn btn-primary float-right">Form pendaftaran</a>
    </div>
</div>

<div class="card mr-5 ml-5 mt-2">
    <div class="card-header">
        <span class="h3">Data Pendaftar</span>
        <a href="buat_jadwal.php" class="float-right btn btn-success ml-2">
        Buat Jadwal
        </a>
        <a href="kosong.php" class="float-right btn btn-danger">
        Kosongkan Tabel
        </a>
    </div>
    <div class="card-body col-lg-12 col-md-12 col-xs-12 table-responsive">
    <div class="h5 mb-3">Total : <b><?= $r["total_jam"] ?> jam</b></div>
        <!-- <div class="table-responsive-lg-12"> -->
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Instruktur</th>
                    <th scope="col">Jumlah Jam</th>
                    <th scope="col">Senin</th>
                    <th scope="col">Selasa</th>
                    <th scope="col">Rabu</th>
                    <th scope="col">Kamis</th>
                    <th scope="col">Jumat</th>
                    <th scope="col">Sabtu</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                while($h = mysqli_fetch_array($ambil)):
                ?>
                    <tr>
                    <th scope="row"><?= $no++ ?></th>
                    <td><?= $h['nama_instruktur'] ?></td>
                    <td><?= $h['jumlah_jam'] ?></td>
                    <?= ($h['senin'] == 1)? "<td class='bg-success'>X</td>":"<td></td>" ?>
                    <?= ($h['selasa'] == 1)? "<td class='bg-success'>X</td>":"<td></td>" ?>
                    <?= ($h['rabu'] == 1)? "<td class='bg-success'>X</td>":"<td></td>" ?>
                    <?= ($h['kamis'] == 1)? "<td class='bg-success'>X</td>":"<td></td>" ?>
                    <?= ($h['jumat'] == 1)? "<td class='bg-success'>X</td>":"<td></td>" ?>
                    <?= ($h['sabtu'] == 1)? "<td class='bg-success'>X</td>":"<td></td>" ?>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <!-- </div> -->
    </div>
</div>

    
<script src="assets/js/jquery-3.4.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>