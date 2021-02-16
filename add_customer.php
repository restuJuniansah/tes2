<?php
//session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';
require_once './lib/process.php';
//require_once 'customers.php';

//serve POST method, After successful insert, redirect to customers.php page.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    //$data_to_store = array_filter($_POST);

    //Insert timestamp
    //$data_to_store['created_at'] = date('Y-m-d H:i:s');
    //$db = getDbInstance();

//images
    $var1 = rand(1111,9999);  // generate random number in $var1 variable
    $var2 = rand(1111,9999);  // generate random number in $var2 variable

    $var3 = $var1.$var2;  // concatenate $var1 and $var2 in $var3
    $var3 = md5($var3);   // convert $var3 using md5 function and generate 32 characters hex number

    $fnm = $_FILES["receipt_picture"]["name"];    // get the image name in $fnm variable
    $dst = "assets/img/".$var3.$fnm;  // storing image path into the {all_images} folder with 32 characters hex number and file name
    $dst_db = "assets/img/".$var3.$fnm;

    move_uploaded_file($_FILES["receipt_picture"]["tmp_name"],$dst);

    $transaksi_id = $_POST['transaksi_id'];
 	 $namadriver = $_POST['driver_name'];
 	 $transaksi = $_POST['driver_channel'];
 	 $nourut = $_POST['number'];
   $created_date = $date;
   $created_time = $hour;
   $sid = ['sid'];
 	 $storename = $_POST['store_name'];
   $storetype = $_POST['store_type'];
   $cid = $_POST['cid'];
   $merchantname = $_POST['merchant_name'];
 	 $gmv = $_POST['gmv'];
 	 $kecamatan = $_POST['kecamatan'];
 	 $kelurahan = $_POST['kelurahan'];
   $buildingname = $_POST['building_name'];
   $fotoharga = $_POST['receipt_picture'];
   $fotoalamat = $_POST['destination_picture'];
   $updated = $_POST['updated_date'];
   $createdby = $_POST['created_by'];
   $Updatedby = $_POST['updated_by'];

$servername='localhost';
$username='root';
$password='';
$dbname = "corephpadmin";
 $db=mysqli_connect($servername,$username,$password,$dbname);
 if(!$db){
   die('Could not Connect My Sql:' .mysql_error());
}

$sql = "INSERT INTO per_transaction_gmv (transaksi_id,driver_name,driver_channel,number,created_date,created_time,sid,store_name,store_type,cid,merchant_name,gmv,kecamatan,kelurahan,building_name,receipt_picture,destination_picture,updated_date,created_by,updated_by)
VALUES ('$transaksi_id','$namadriver','$transaksi','$nourut','$created_date','$created_time','$sid','$storename','$storetype','$cid','$merchantname','$gmv','$kecamatan','$kelurahan','$buildingname','$dst_db','$fotoalamat','$updated','$createdby','$Updatedby')";

if (mysqli_query($db, $sql)) {
 echo "Data berhasil disimpan !";
} else {
 echo "Error: " . $sql . "
" . mysqli_error($db);
}
mysqli_close($db);
}
/*
    $last_id = $db->insert('per_transaction_gmv', $data_to_store);

    if($last_id)
    {
    	$_SESSION['success'] = "Customer added successfully!";
    	header('location: customers.php');
    	exit();
    }
    else
    {
        echo 'insert failed: ' . $db->getLastError();
        exit();
    }
}
*/
//We are using same form for adding and editing. This is a create form so declare $edit = false.
$edit = false;

require_once 'includes/header.php';
?>
<div id="page-wrapper">
<div class="row">
     <div class="col-lg-12">
            <h2 class="page-header">Add Customers</h2>
        </div>

</div>
    <form class="form" action="" method="post"  id="customer_form" enctype="multipart/form-data">
       <?php  include_once('./forms/customer_form.php'); ?>
    </form>
</div>


<script type="text/javascript">
$(document).ready(function(){
   $("#customer_form").validate({
       rules: {
            f_name: {
                required: true,
                minlength: 3
            },
            l_name: {
                required: true,
                minlength: 3
            },
        }
    });
});
</script>

<?php include_once 'includes/footer.php'; ?>
