<?php

include "koneksi.php";
error_reporting(0);
$query = "SELECT * FROM pendaftaran";
$ambil = mysqli_query($konek, $query);
$backup = [];
while ($h = mysqli_fetch_assoc($ambil)) {
    if ($h["senin"] == 1) {
        $senin[$h["id_pendaftar"]] = $h["jumlah_jam"];
    } elseif ($h["selasa"] == 1) {
        $selasa[$h["id_pendaftar"]] = $h["jumlah_jam"];
    } elseif ($h["rabu"] == 1) {
        $rabu[$h["id_pendaftar"]] = $h["jumlah_jam"];
    } elseif ($h["kamis"] == 1) {
        $kamis[$h["id_pendaftar"]] = $h["jumlah_jam"];
    } elseif ($h["jumat"] == 1) {
        $jumat[$h["id_pendaftar"]] = $h["jumlah_jam"];
    } elseif ($h["sabtu"] == 1) {
        $sabtu[$h["id_pendaftar"]] = $h["jumlah_jam"];
    }
    $backup[] = $h;
}

function susunJadwal($data)
{
    ksort($data);
    // ( [3] => 2 [10] => 3 [18] => 3 [21] => 2 [23] => 3 [26] => 2 [30] => 2 )
    $key_data = array_keys($data);
    // print_r($key_data);
    echo "<br>";

    $index = 0;
    $max_jam = 0;
    $jadwal = [];
    foreach ($data as $key => $value) {
        // 2? > 9
        if (($max_jam + $data[$key_data[$index]]) >= 9 && isset($data[$key_data[$index]])) {

            while ($max_jam + $data[$key_data[$index]] >= 9) { // ya
                if (isset($key_data[$index + 1])) {
                    $index++; // 3
                } else {
                    break;
                }
            }

            if (isset($key_data[$index]) && ($max_jam != 8)) {
                if (isset($data[$key_data[$index]])) {
                    $max_jam += $data[$key_data[$index]];
                    $jadwal[] = $key_data[$index];
                }
            }

            break;
        }
        $max_jam += $value; // menambahkan jam sampai max 8 => 5
        $jadwal[] = $key;  // mamasukkan instruktur yang mengajar => 3, 10
        $index++; // 1, 2
    }

    return [$max_jam, $jadwal];
}


function ambilSisa($hasil, $data_hari)
{
    $jadwal = $hasil;

    $belum_punya = array_filter($data_hari, function ($k) use ($jadwal) {
        return !in_array($k, $jadwal);
    }, ARRAY_FILTER_USE_KEY);

    return $belum_punya;
}

$tunda = [];
function gabungDataSelasa($sisa_data, $backup)
{
    global $selasa, $rabu, $kamis, $jumat, $sabtu, $tunda;

    foreach ($sisa_data as $key => $value) {
        foreach ($backup as $data) {

            if ($data["id_pendaftar"] == $key) {
                if ($data["selasa"] == 1) {
                    $selasa[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["rabu"] == 1) {
                    $rabu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["kamis"] == 1) {
                    $kamis[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["jumat"] == 1) {
                    $jumat[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["sabtu"] == 1) {
                    $sabtu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } else {
                    $tunda[] = $key;
                }
            }
        }
    }
}

function gabungDataRabu($sisa_data, $backup)
{
    global $rabu, $kamis, $jumat, $sabtu, $tunda;
    foreach ($sisa_data as $key => $value) {
        foreach ($backup as $data) {
            if ($data["id_pendaftar"] == $key) {
                if ($data["rabu"] == 1) {
                    $rabu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["kamis"] == 1) {
                    $kamis[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["jumat"] == 1) {
                    $jumat[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["sabtu"] == 1) {
                    $sabtu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } else {
                    $tunda[] = $key;
                }
            }
        }
    }
}

function gabungDataKamis($sisa_data, $backup)
{
    global $kamis, $jumat, $sabtu, $tunda;
    foreach ($sisa_data as $key => $value) {
        foreach ($backup as $data) {
            if ($data["id_pendaftar"] == $key) {
                if ($data["kamis"] == 1) {
                    $kamis[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["jumat"] == 1) {
                    $jumat[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["sabtu"] == 1) {
                    $sabtu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } else {
                    $tunda[] = $key;
                }
            }
        }
    }
}

function gabungDataJumat($sisa_data, $backup)
{
    global $jumat, $sabtu, $tunda;
    foreach ($sisa_data as $key => $value) {
        foreach ($backup as $data) {
            if ($data["id_pendaftar"] == $key) {
                if ($data["jumat"] == 1) {
                    $jumat[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } elseif ($data["sabtu"] == 1) {
                    $sabtu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } else {
                    $tunda[] = $key;
                }
            }
        }
    }
}

function gabungDataSabtu($sisa_data, $backup)
{
    global $sabtu, $tunda;
    foreach ($sisa_data as $key => $value) {
        foreach ($backup as $data) {
            if ($data["id_pendaftar"] == $key) {
                if ($data["sabtu"] == 1) {
                    $sabtu[$data["id_pendaftar"]] = $data["jumlah_jam"];
                } else {
                    $tunda[] = $key;
                }
            }
        }
    }
}

// Hari senin [1] => 3 [6] => 3 [8] => 3 [15] => 2 [17] => 3 [18] => 3 [20] => 3 [23] => 3 [30] => 2
$jadwal_senin = susunJadwal($senin)[1]; // [0] => 1 [1] => 6 [2] => 15
$sisa_senin = ambilSisa($jadwal_senin, $senin); // [8] => 3 [17] => 3 [18] => 3 [20] => 3 [23] => 3 [30] => 2 
// 8 sabtu dan 20 kamis

// Hari Selasa [2] => 2 [4] => 2 [9] => 2 [10] => 3 [25] => 2 [26] => 2
gabungDataSelasa($sisa_senin, $backup);
// [2] => 2 [4] => 2 [9] => 2 [10] => 3 [25] => 2 [26] => 2 [17] => 3 [18] => 3 [23] => 3 [30] => 2 
$jadwal_selasa = susunJadwal($selasa)[1]; // [0] => 2 [1] => 4 [2] => 9 [3] => 25 
$sisa_selasa = ambilSisa($jadwal_selasa, $selasa); // [10] => 3 [26] => 2 [17] => 3 [18] => 3 [23] => 3 [30] => 2 
// 17 kamis

// Hari Rabu [3] => 2 [21] => 2
// print_r($rabu);
gabungDataRabu($sisa_selasa, $backup);
// [3] => 2 [21] => 2 [10] => 3 [26] => 2 [18] => 3 [23] => 3 [30] => 2
$jadwal_rabu = susunJadwal($rabu)[1]; // [0] => 3 [1] => 10 [2] => 18 [3] => 30 
$sisa_rabu = ambilSisa($jadwal_rabu, $rabu); // [21] => 2 [26] => 2 [23] => 3
// die;

// Hari Kamis

gabungDataKamis($sisa_rabu, $backup);

$jadwal_kamis = susunJadwal($kamis)[1];
$sisa_kamis = ambilSisa($jadwal_kamis, $kamis);

// Hari Jumat
// print_r($jumat);
// echo "<br>";
gabungDataJumat($sisa_kamis, $backup);
// print_r($jumat);

$jadwal_jumat = susunJadwal($jumat)[1];
$sisa_jumat = ambilSisa($jadwal_jumat, $jumat);
// print_r(susunJadwal($jumat)[0]);
// die;

// Hari Sabtu

gabungDataSabtu($sisa_jumat, $backup);


$jadwal_sabtu = susunJadwal($sabtu)[1];
$sisa_sabtu = ambilSisa($jadwal_sabtu, $sabtu);

foreach ($sisa_sabtu as $key => $value) {
    $tunda[] = $key;
}
asort($tunda);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>

    <div class="card mr-5 ml-5 mb-2 mt-5">
        <div class="card-body">
            <span class="h1">Ekoji Academy</span>
            <a href="index.php" class="btn btn-primary float-right">Form pendaftaran</a>
        </div>
    </div>

    <div class="card mr-5 ml-5 mt-2">
        <div class="card-header">
            <span class="h3">Jadwal</span>
            <a href="daftar_data.php" class="float-right btn btn-success">
                Kembali Data Pendaftar
            </a>
        </div>
        <div class="card-body col-lg-12 col-md-12 col-xs-12 table-responsive">

            <!-- <div class="table-responsive-lg-12"> -->
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th scope="col">Jadwal</th>
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
                    $data_jam = [];
                    foreach ($backup as $key => $value) {
                        $data_jam["jam_" . $value["id_pendaftar"]] = $value["jumlah_jam"];
                        $data_jam["nama_" . $value["id_pendaftar"]] = $value["nama_instruktur"];
                    }
                    $total_jam_tunda = 0;
                    $list_nama_jam = [];
                    foreach ($tunda as $val) {
                        $total_jam_tunda += $data_jam["jam_" . $val];
                        $list_nama_jam[] = $data_jam["nama_" . $val] . " (" . $data_jam["jam_" . $val] . ")";
                    }
                    $jam = 8;
                    // print_r($list_nama_jam);
                    // die;
                    while ($jam < 16) :
                    ?>
                        <tr>
                            <th scope="row"><?= $jam . ".00 - " . ($jam + 1) . ".00" ?></th>
                            <td>
                                <?php
                                foreach ($jadwal_senin as $key => $value) {
                                    if ($data_jam["jam_" . $value] > 0) {
                                        echo $data_jam["nama_" . $value];
                                        $data_jam["jam_" . $value]--;
                                        break;
                                    } else {
                                        unset($jadwal_senin[$key]);
                                    }
                                }

                                ?></td>
                            <td> <?php
                                    foreach ($jadwal_selasa as $key => $value) {
                                        if ($data_jam["jam_" . $value] > 0) {
                                            echo $data_jam["nama_" . $value];
                                            $data_jam["jam_" . $value]--;
                                            break;
                                        } else {
                                            unset($jadwal_selasa[$key]);
                                        }
                                    }

                                    ?></td>
                            <td><?php
                                foreach ($jadwal_rabu as $key => $value) {
                                    if ($data_jam["jam_" . $value] > 0) {
                                        echo $data_jam["nama_" . $value];
                                        $data_jam["jam_" . $value]--;
                                        break;
                                    } else {
                                        unset($jadwal_rabu[$key]);
                                    }
                                }

                                ?></td>
                            <td><?php
                                foreach ($jadwal_kamis as $key => $value) {
                                    if ($data_jam["jam_" . $value] > 0) {
                                        echo $data_jam["nama_" . $value];
                                        $data_jam["jam_" . $value]--;
                                        break;
                                    } else {
                                        unset($jadwal_kamis[$key]);
                                    }
                                }

                                ?></td>
                            <td><?php
                                foreach ($jadwal_jumat as $key => $value) {
                                    if ($data_jam["jam_" . $value] > 0) {
                                        echo $data_jam["nama_" . $value];
                                        $data_jam["jam_" . $value]--;
                                        break;
                                    } else {
                                        unset($jadwal_jumat[$key]);
                                    }
                                }

                                ?></td>
                            <td><?php
                                foreach ($jadwal_sabtu as $key => $value) {
                                    if ($data_jam["jam_" . $value] > 0) {
                                        echo $data_jam["nama_" . $value];
                                        $data_jam["jam_" . $value]--;
                                        break;
                                    } else {
                                        unset($jadwal_sabtu[$key]);
                                    }
                                }

                                ?></td>

                        </tr>

                    <?php
                        $jam++;
                    endwhile; ?>
                </tbody>
            </table>
            <div class="h5 mt-3">Total yang tidak bisa dialokasikan adalah : <b><?= $total_jam_tunda ?> jam</b></div>
            <div class="h5 mt-3">
                Nama yang baru bisa mengajar minggu berikutnya adalah :
                <?php

                foreach ($list_nama_jam as $key => $val) {
                    if ($key == (count($list_nama_jam) - 1)) {
                        echo "dan " . $val;
                    } else {
                        echo $val . ", ";
                    }
                }
                ?>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery-3.4.1.slim.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>