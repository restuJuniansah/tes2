<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

function compress($source, $destination, $quality) {

    $info = getimagesize($source);

    if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source);

    elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source);

    elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source);

    imagejpeg($image, $destination, $quality);

    return $destination;
}

//receiptimage
$var1 = rand(1111,9999);  // generate random number in $var1 variable
$var2 = rand(1111,9999);  // generate random number in $var2 variable

$var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
$var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number
$res = "resize_";

$fnm = $_FILES["receipt_picture"]["name"];    // get the image name in $fnm variable
$dst = "./assets/img/receipt/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
move_uploaded_file($_FILES["receipt_picture"]["tmp_name"],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name

$dst_db = "./assets/img/receipt/".$res.$var3.$fnm; // storing image path into the database with 32 characters hex number and file name

$d = compress($dst, $dst_db, 10);
unlink($dst);

//destinationimage
$vr1 = rand(1111,9999);  // generate random number in $var1 variable
$vr2 = rand(1111,9999);  // generate random number in $var2 variable

$vr3 = $vr1.$vr2;  // concatenate $var1 and $var2 in $var3
$vr3 = md5($vr3);   // convert $var3 using md5 function and generate 32 characters hex number
$res = "resize_";

$fnam = $_FILES["destination_picture"]["name"];    // get the image name in $fnm variable
$dstt = "./assets/img/destination/".$vr3.$fnam;  // storing image path into the {all_images} folder with 32 characters hex number and file name
move_uploaded_file($_FILES["destination_picture"]["tmp_name"],$dstt);  // move image into the {all_images} folder with 32 characters hex number and image name

$dstt_db = "./assets/img/destination/".$res.$var3.$fnam; // storing image path into the database with 32 characters hex number and file name

$d = compress($dstt, $dstt_db, 10);
unlink($dstt);

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    //Insert timestamp
    $data_to_store['created_date'] = date('Y-m-d');
    $data_to_store['receipt_picture'] = $dst_db;
    $data_to_store['destination_picture'] = $dstt_db;
    $data_to_store['created_by']= $_SESSION['users_name'];

    $db = getDbInstance();

    $last_id = $db->insert('per_transaction_gmv', $data_to_store);

    if($last_id)
    {
    	$_SESSION['success'] = "Data Berhasil Di Simpan!";

        $db = getDbInstance();
        if($db->delete('last'));
        $data = Array ("name" => $_SESSION['users_name']);
        $id = $db->insert ('last', $data);

    	header('location: customers.php');
    	exit();
    }
    else
    {
        echo 'Data Gagal Di Simpan: ' . $db->getLastError();
        exit();
    }
}
?>
<?php include_once 'includes/footer.php'; ?>
