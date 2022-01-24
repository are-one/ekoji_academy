<?php 
include "koneksi.php";

$nama_instruktur = $_POST["nama_instruktur"];
$jumlah_jam = (isset($_POST["jumlah_jam"]))? $_POST["jumlah_jam"]:0;
$senin = (isset($_POST["senin"]))?$_POST["senin"]:0;
$selasa = (isset($_POST["selasa"]))?$_POST["selasa"]:0;
$rabu = (isset($_POST["rabu"]))?$_POST["rabu"]:0;
$kamis = (isset($_POST["kamis"]))?$_POST["kamis"]:0;
$jumat = (isset($_POST["jumat"]))?$_POST["jumat"]:0;
$sabtu = (isset($_POST["sabtu"]))?$_POST["sabtu"]:0;

$cek = mysqli_query($konek,"select if(sum(jumlah_jam) is NULL, 0,sum(jumlah_jam) + 3) < 63 as cek from pendaftaran");
$boleh = mysqli_fetch_array($cek);
if($jumlah_jam < 1){
    header("Location:index.php?pesan=1");
    die;
}
if($boleh['cek']){
    $query = "
    INSERT INTO pendaftaran 
    VALUES (null,
            '$nama_instruktur',
            $jumlah_jam,
            $senin,
            $selasa,
            $rabu,
            $kamis,
            $jumat,
            $sabtu)
";

    $insert = mysqli_query($konek, $query);
    header("Location:index.php?pesan=2");
    die;
}else{
   header("Location:tutup.php");
}
