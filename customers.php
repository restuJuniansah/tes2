<?php
session_start();
require_once 'config/config.php';
require_once BASE_PATH . '/includes/auth_validate.php';
require_once './lib/process.php';

// Costumers class
require_once BASE_PATH . '/lib/Costumers/Costumers.php';
$costumers = new Costumers();

// Get Input data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');

// Per page limit for pagination.
$pagelimit = 15;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'transaksi_id';
}
if (!$order_by) {
	$order_by = 'Desc';
}

//Get DB instance. i.e instance of MYSQLiDB Library
$db = getDbInstance();
$select = array('transaksi_id', 'driver_name', 'driver_channel', 'number', 'created_date', 'created_time', 'sid', 'store_name', 'store_type', 'cid', 'merchant_name', 'gmv', 'kecamatan', 'kelurahan', 'building_name', 'receipt_picture', 'destination_picture', 'updated_date', 'created_by',
'updated_by');

//Start building query according to input parameters.
// If search string
if ($search_string) {
	$db->where('f_name', '%' . $search_string . '%', 'like');
	$db->orwhere('l_name', '%' . $search_string . '%', 'like');
}

//If order by option selected
if ($order_by) {
	$db->orderBy($filter_col, $order_by);
}

// Set pagination limit
$db->pageLimit = $pagelimit;

// Get result of the query.
$rows = $db->arraybuilder()->paginate('per_transaction_gmv', $page, $select);
$total_pages = $db->totalPages;

include BASE_PATH . '/includes/header.php';


?>


<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Customers</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-datamodal"><i class="glyphicon glyphicon-plus"></i> Add new</button>
            </div>
        </div>
    </div>
    <?php include BASE_PATH . '/includes/flash_messages.php';?>

		<!-- Modal -->
		<div class="modal fade" id="add-datamodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog" role="document">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h3 class="modal-title text-center" id="exampleModalLabel">FORM ORDER</h3>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <div class="modal-body">

						<form method="post" action="add_customer.php" enctype="multipart/form-data">

							<div class="form-group hidden">
								<input type="text" class="form-control" name="transaksi_id" value="<?php echo (isset($transaksi_id))?$transaksi_id:'';?>">
							</div>

							<div class="form-group">
								<label for="namadriver">Nama Driver</label>
								<input type="text" class="form-control" name="driver_name" id="namadriver" placeholder="Nama Driver" required="required">
							</div>

<!--							<label>Channel Transaksi</label><br> -->

								<div class="form-group">
									<label for="namadriver">Channel Transaksi</label>
									<input type="text" class="form-control" name="driver_channel" id="namadriver" placeholder="Nama Driver" value="required">
								</div>

					<!--		<div class="btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" id="Gojek" autocomplete="off">Gojek
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" id="Grab" autocomplete="off">Grab
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" id="GrabPesanSekaligus" autocomplete="off">Grab Pesan Sekaligus
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" id="Walkin" autocomplete="off">Walk In
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" id="Ecommerce" autocomplete="off">E-Commerce
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" id="KKO" autocomplete="off">KKO
								</label>
							</div>
							<br>
-->
							<div class="form-group">
								<label>Nomor Urut</label>
								<input type="number" class="form-control" name="number" id="nourut" placeholder="Nomor Urut" required="required">
							</div>
							<?php echo "tanggal".$date?>
							<div class="form-group hidden">
								<input type="text" class="form-control" name="created_date" value="<?php echo $date?>">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="created_time" value="<?php echo $hour?>">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="sid" value="1">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="store_name" value="nama toko">
							</div>

		<!--					<div class="btn-group-toggle" data-toggle="buttons">
								<label>Lokasi Kita Kitchen</label><br>
								<label class="btn btn-primary">
									<input type="radio" name="store_name" id="Pesanggrahan" autocomplete="off">Flagship Kitchen-Pesanggrahan
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="store_name" id="B" autocomplete="off">Flagship Kitchen-B
								</label>
							</div>
							<br>
-->
							<div class="form-group hidden">
								<input type="text" class="form-control" name="store_type" value="Flagship Kitchen">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="cid" value="1">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="merchant_name" value="merchantname">
							</div>

							<div class="form-group">
								<label>Total Harga di Aplikasi</label>
								<input type="number" class="form-control" name="gmv" id="totalaplikasi" placeholder="Total Harga di Aplikasi" required="required">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="kecamatan" value="<?php echo (isset($date))?$date:'';?>">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="kelurahan" value="<?php echo (isset($date))?$date:'';?>">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="building_name" value="<?php echo (isset($date))?$date:'';?>">
							</div>

							<div class="form-group">
								<label>Foto Harga Orderan</label>
								<input name="receipt_picture" type="file" accept="image/*">
							</div>

							<div class="form-group">
								<label>Foto Alamat Pengirim</label>
								<input id="input-b1" name="destination_picture" type="file" class="file" accept="image/*" data-browse-on-zone-click="true">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="updated_date" value="<?php echo $updatetime?>">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="created_by" value="me">
							</div>

							<div class="form-group hidden">
								<input type="text" class="form-control" name="updated_by" value="someone">
							</div>
		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-warning center-block" name="save"><span class="glyphicon glyphicon-save"> Simpan</button>
		      </div>
					</form>
		    </div>
		  </div>
		</div>

    <!-- Filters -->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search">Search</label>
            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo xss_clean($search_string); ?>">
            <label for="input_order">Order By</label>
            <select name="filter_col" class="form-control">
                <?php
foreach ($costumers->setOrderingValues() as $opt_value => $opt_name):
	($order_by === $opt_value) ? $selected = 'selected' : $selected = '';
	echo ' <option value="' . $opt_value . '" ' . $selected . '>' . $opt_name . '</option>';
endforeach;
?>
            </select>
            <select name="order_by" class="form-control" id="input_order">
                <option value="Asc" <?php
if ($order_by == 'Asc') {
	echo 'selected';
}
?> >Asc</option>
                <option value="Desc" <?php
if ($order_by == 'Desc') {
	echo 'selected';
}
?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->


    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>
    </div>

    <!-- Table -->
		Last edited by :
		<div class="table-responsive">
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
							<th width="5%">tid</th>
							<th width="45%">driver_name</th>
							<th width="20%">driver_channel</th>
							<th width="20%">number</th>
							<th width="20%">created_date</th>
							<th width="20%">created_time</th>
							<th width="20%">sid</th>
							<th width="20%">store_name</th>
							<th width="20%">store_type</th>
							<th width="20%">cid</th>
							<th width="20%">brand_name</th>
							<th width="20%">gmv</th>
							<th width="20%">kecamatan</th>
							<th width="20%">kelurahan</th>
							<th width="20%">building_name</th>
							<th width="20%">receipt_picture</th>
							<th width="20%">destination_picture</th>
							<th width="20%">updated_date</th>
							<th width="20%">created_by</th>
							<th width="20%">updated_by</th>
							<th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
							<td><?php echo $row['transaksi_id']; ?></td>
							<td><?php echo xss_clean($row['driver_name']); ?></td>
							<td><?php echo xss_clean($row['driver_channel']); ?></td>
							<td><?php echo xss_clean($row['number']); ?></td>
							<td><?php echo xss_clean($row['created_date']); ?></td>
							<td><?php echo xss_clean($row['created_time']); ?></td>
							<td><?php echo xss_clean($row['sid']); ?></td>
							<td><?php echo xss_clean($row['store_name']); ?></td>
							<td><?php echo xss_clean($row['store_type']); ?></td>
							<td><?php echo xss_clean($row['cid']); ?></td>
							<td><?php echo xss_clean($row['merchant_name']); ?></td>
							<td><?php echo xss_clean($row['gmv']); ?></td>
							<td><?php echo xss_clean($row['kecamatan']); ?></td>
							<td><?php echo xss_clean($row['kelurahan']); ?></td>
							<td><?php echo xss_clean($row['building_name']); ?></td>
							<?php $imageurl='./assets/img'.$row["receipt_picture"];?>
							<td><img src="<?php echo xss_clean($imageurl); ?>"</td>
							<td><?php echo xss_clean($row['destination_picture']); ?></td>
							<td><?php echo xss_clean($row['updated_date']); ?></td>
							<td><?php echo xss_clean($row['created_by']); ?></td>
							<td><?php echo xss_clean($row['updated_by']); ?></td>
                <td>
                    <a href="edit_customer.php?customer_id=<?php echo $row['transaksi_id']; ?>&operation=edit" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['transaksi_id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['transaksi_id']; ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_customer.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['transaksi_id']; ?>">
                                <p>Are you sure you want to delete this row?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- //Delete Confirmation Modal -->
            <?php endforeach;?>
        </tbody>
    </table>
	</div>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
    <?php echo paginationLinks($page, $total_pages, 'customers.php'); ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
<?php include BASE_PATH . '/includes/footer.php';?>
