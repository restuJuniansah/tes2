<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';
$del_id = filter_input(INPUT_POST, 'del_id');
if ($del_id && $_SERVER['REQUEST_METHOD'] == 'POST')
{

	if($_SESSION['admin_type']!='super'){
		$_SESSION['failure'] = "You don't have permission to perform this action";
    	header('location: customers.php');
        exit;

	}
    $customer_id = $del_id;

    $db = getDbInstance();

    $db->where('transaksi_id', $customer_id);
		$customer = $db->getOne("per_transaction_gmv");
		$status = unlink($customer['receipt_picture']) && unlink($customer['destination_picture']); //hapus picture di folder
		//$status = $db->delete('per_transaction_gmv');

    if ($status)
    {
				$db = getDbInstance();

	    	$db->where('transaksi_id', $customer_id);
				$delete = $db->delete('per_transaction_gmv'); //delete data

				if ($delete)
				{
					$_SESSION['info'] = "Customer deleted successfully!";

					$db = getDbInstance();
					if($db->delete('last'));
					$data = Array ("name" => $_SESSION['users_name']);
					$id = $db->insert ('last', $data);

	        header('location: customers.php');
	        exit;
				}
				else
				{
					$_SESSION['failure'] = "Unable to delete customer";
		    	header('location: customers.php');
		      exit;
				}

    }
    else
    {
			$db = getDbInstance();

			$db->where('transaksi_id', $customer_id);
			$delete = $db->delete('per_transaction_gmv'); //delete data

			if ($delete)
			{
				$_SESSION['info'] = "Customer deleted successfully!";

				$db = getDbInstance();
				if($db->delete('last'));
				$data = Array ("name" => $_SESSION['users_name']);
				$id = $db->insert ('last', $data);

				header('location: customers.php');
				exit;
			}
			else
			{
				$_SESSION['failure'] = "Unable to delete customer";
				header('location: customers.php');
				exit;
			}

    }

}

?>
