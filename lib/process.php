<?php
require_once './config/config.php';
//require_once '../authenticate.php';

//generate random string
$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}

//getdate
$transaksi_id = generate_string($permitted_chars, 7);
$date=date('Y-m-d');
$hour=date('H:i');
$updatetime=date('Y-m-d H:i:s');

$db=getDbInstance();


/*
if(isset($_POST['save']))
{
   $transaksi_id = generate_string($permitted_chars, 7);
	 $namadriver = $_POST['namadriver'];
	 $transaksi = $_POST['transaksi'];
   $created_date = $date;
   $created_time = $hour;
	 $nourut = $_POST['nourut'];
	 $lokasi = $_POST['lokasi'];
   $merchant = $_POST['merchant'];
	 $totalaplikasi = $_POST['totalaplikasi'];
	 $kecamatan = $_POST['kecamatan'];
	 $kelurahan = $_POST['kelurahan'];
   $jenislok = $_POST['jenislok'];
   $fotoharga = $_POST['fotoharga'];
   $fotoalamat = $_POST['fotoalamat'];
   $update_time = $updatetime;

	 $sql = "INSERT INTO per_transaction_gmv (transaksi_id,driver_name,driver_channel,created_date,created_time,store_name,merchant_name,kecamatan,kelurahan,building_name,receipt_picture,destination_picture,updated_date)
	 VALUES ('$transaksi_id','$namadriver','$transaksi','$created_date','$created_time','$lokasi','$merchant','$kecamatan','$kelurahan','$jenislok','$fotoharga','$fotoalamat','$update_time')";
	 if (mysqli_query($db, $sql)) {
		echo "Data berhasil disimpan !";
	 } else {
		echo "Error: " . $sql . "
" . mysqli_error($db);
	 }
	 mysqli_close($db);
}*/
?>
