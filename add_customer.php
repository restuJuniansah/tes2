<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

//receiptimage
$var1 = rand(1111,9999);  // generate random number in $var1 variable
$var2 = rand(1111,9999);  // generate random number in $var2 variable

$var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
$var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

$fnm = $_FILES["receipt_picture"]["name"];    // get the image name in $fnm variable
$dst = "./assets/img/receipt/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
$dst_db = "assets/img/receipt/".$var3.$fnm; // storing image path into the database with 32 characters hex number and file name

move_uploaded_file($_FILES["receipt_picture"]["tmp_name"],$dst);  // move image into the {all_images} folder with 32 characters hex number and image name

//destinationimage
$vr1 = rand(1111,9999);  // generate random number in $var1 variable
$vr2 = rand(1111,9999);  // generate random number in $var2 variable

$vr3 = $vr1.$vr2;  // concatenate $var1 and $var2 in $var3
$vr3 = md5($vr3);   // convert $var3 using md5 function and generate 32 characters hex number

$fnam = $_FILES["destination_picture"]["name"];    // get the image name in $fnm variable
$dstt = "./assets/img/destination/".$vr3.$fnam;  // storing image path into the {all_images} folder with 32 characters hex number and file name
$dstt_db = "assets/img/destination/".$vr3.$fnam; // storing image path into the database with 32 characters hex number and file name

move_uploaded_file($_FILES["destination_picture"]["tmp_name"],$dstt);  // move image into the {all_images} folder with 32 characters hex number and image name


//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = array_filter($_POST);

    //Insert timestamp
    $data_to_store['receipt_picture'] = $dst_db;
    $data_to_store['destination_picture'] = $dstt_db;
    $data_to_store['created_by']= $_SESSION['users_name'];

    $db = getDbInstance();

    $last_id = $db->insert('per_transaction_gmv', $data_to_store);

    if($last_id)
    {
    	$_SESSION['success'] = "Data Berhasil Di Simpan!";
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
