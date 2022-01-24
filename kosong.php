<?php 

include "koneksi.php";

$query = "TRUNCATE TABLE pendaftaran";

$exect = mysqli_query($konek,$query);

mysqli_error($konek);

header("Location:daftar_data.php");