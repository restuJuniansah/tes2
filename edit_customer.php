<?php
session_start();
require_once './config/config.php';
require_once './includes/auth_validate.php';

// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'transaksis_id', FILTER_SANITIZE_STRING);
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method,
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //Get customer id form query string parameter.
    $customer_id = filter_input(INPUT_GET, 'transaksis_id', FILTER_SANITIZE_STRING);
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

    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);

//logic update gambar
    if($fnm != "") //receipt picture diedit
    {
      $data_to_update['updated_date'] = date('Y-m-d H:i');
      $data_to_update['updated_by']= $_SESSION['users_name'];
      $data_to_update['receipt_picture'] = $dst_db;
      $db = getDbInstance();
      $db->where('transaksi_id',$customer_id);
      $stat = $db->update('per_transaction_gmv', $data_to_update);
    }
    else if($fnam !="") //destination_picture diedit
    {
      $data_to_update['updated_date'] = date('Y-m-d H:i');
      $data_to_update['updated_by']= $_SESSION['users_name'];
      $data_to_update['destination_picture'] = $dstt_db;
      $db = getDbInstance();
      $db->where('transaksi_id',$customer_id);
      $stat = $db->update('per_transaction_gmv', $data_to_update);
    }
    else if($fnm !="" && $fnam !="") //destination_picture & receipt diedit
    {
      $data_to_update['updated_date'] = date('Y-m-d H:i');
      $data_to_update['updated_by']= $_SESSION['users_name'];
      $data_to_update['receipt_picture'] = $dst_db;
      $data_to_update['destination_picture'] = $dstt_db;
      $db = getDbInstance();
      $db->where('transaksi_id',$customer_id);
      $stat = $db->update('per_transaction_gmv', $data_to_update);
    }
    else //destination & receipt tidak diedit
    {
    $data_to_update['updated_date'] = date('Y-m-d H:i');
    $data_to_update['updated_by']= $_SESSION['users_name'];
    $db = getDbInstance();
    $db->where('transaksi_id',$customer_id);
    $stat = $db->update('per_transaction_gmv', $data_to_update);
    }
    if($stat)
    {
        $_SESSION['success'] = "Data Berhasil di Update!";

        $db = getDbInstance();
        if($db->delete('last'));
        $data = Array ("name" => $_SESSION['users_name']);
        $id = $db->insert ('last', $data);
        
        //Redirect to the listing page,
        header('location: customers.php');
        //Important! Don't execute the rest put the exit/die.
        exit();
    }
}

//If edit variable is set, we are performing the update operation.
    $db->where('transaksi_id', $customer_id);
    //Get data to pre-populate the form.
    $customer = $db->getOne("per_transaction_gmv");
?>

<?php
    include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <h2 class="page-header">Update Customer</h2>
    </div>
    <!-- Flash messages -->
    <?php
        include('./includes/flash_messages.php')
    ?>

    <form class="" action="" method="post" enctype="multipart/form-data" id="contact_form">

        <?php
            //Include the common form for add and edit
            require_once('./forms/customer_form.php');
        ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>
