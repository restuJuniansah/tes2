<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
require_once './lib/process.php';


// Sanitize if you want
$customer_id = filter_input(INPUT_GET, 'transaksis_id', FILTER_SANITIZE_STRING);
//$operation = filter_input(INPUT_GET, 'operation',FILTER_SANITIZE_STRING);
//($operation == 'edit') ? $edit = true : $edit = false;
 $db = getDbInstance();

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method,
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    //Get customer id form query string parameter.
    $customer_id = filter_input(INPUT_GET, 'transaksis_id', FILTER_SANITIZE_STRING);

    //Get input data
    $data_to_update = filter_input_array(INPUT_POST);

    $data_to_update['updated_date'] = date('Y-m-d H:i');
    $data_to_update['updated_by']= $_SESSION['users_name'];
    $db = getDbInstance();
    $db->where('transaksi_id',$customer_id);
    $stat = $db->update('per_transaction_gmv', $data_to_update);

    if($stat)
    {
        $_SESSION['success'] = "Customer updated successfully!";
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
