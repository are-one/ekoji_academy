<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<!-- BEGIN CARD FOR TITLE -->
<div class="card mr-5 ml-5 mb-2 mt-5">
    <div class="card-body">
        <span class="h1">Ekoji Academy</span>
        <a href="daftar_data.php" class="btn btn-primary float-right">Admin</a>
    </div>
</div>
<!-- END CARD FOR TITLE -->

<?php 
if(isset($_GET['pesan'])):
if($_GET['pesan']==1):
 ?>
 <div class="alert alert-danger mr-5 ml-5" role="alert">
  <b>Jumlah Jam Pelatihan</b> belum diisi!.
</div>
<?php
elseif($_GET['pesan']==2):
?>
<div class="alert alert-success mr-5 ml-5" role="alert">
  <b>Selamat</b> anda berhasil melakukan pendaftaran.
</div>
<?php
endif;
 endif; ?>
 
 <!-- BEGIN CARD FORM -->
<div class="card mr-5 ml-5 mt-2">
    <div class="card-header">
        <span class="h3">Form Pendaftaran</span>
    </div>

    <div class="card-body col-lg-8 col-md-12 col-xs-12">
    <form action="tambah_data.php" method="POST">
        <div class="form-row">
            <div class="form-group col-md-6 mr-4">
            <label for="nama_instruktur">Nama Instruktur</label>
            <input type="text" class="form-control" name="nama_instruktur" id="nama_instruktur" required>
            </div>
            <div class="form-group col-md-4">
                <label for="jam">Jumlah Jam Pelatihan</label>
                <div class="form-group" id="jam">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jumlah_jam" id="1jam" value="1">
                    <label class="form-check-label" for="1jam">1 jam</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jumlah_jam" id="2jam" value="2">
                    <label class="form-check-label" for="2jam">2 jam</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="jumlah_jam" id="3jam" value="3">
                    <label class="form-check-label" for="3jam">3 jam</label>
                </div>
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="senin" name="senin" value="1">
                <label class="form-check-label" for="gridCheck">
                    Senin
                </label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="selasa" name="selasa" value="1">
                <label class="form-check-label" for="gridCheck">
                    Selasa
                </label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rabu" name="rabu" value="1">
                <label class="form-check-label" for="gridCheck">
                    Rabu
                </label>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="kamis" name="kamis" value="1">
                <label class="form-check-label" for="gridCheck">
                    Kamis
                </label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="jumat" name="jumat" value="1">
                <label class="form-check-label" for="gridCheck">
                    Jumat
                </label>
                </div>
            </div>
            <div class="form-group col-md-4">
                <div class="form-check">
                <input class="form-check-input" type="checkbox" id="sabtu" name="sabtu" value="1">
                <label class="form-check-label" for="gridCheck">
                    Sabtu
                </label>
                </div>
            </div>
        </div>
    
    <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
    </div>
</div>
<!-- END CARD FORM -->

    
<script src="assets/js/jquery-3.4.1.slim.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>