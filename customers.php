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
$date = filter_input(INPUT_GET, 'date1');
$date2 = filter_input(INPUT_GET, 'date2');

// Per page limit for pagination.
$pagelimit = 5;

// Get current page.
$page = filter_input(INPUT_GET, 'page');
if (!$page) {
	$page = 1;
}

// If filter types are not selected we show latest added data first
if (!$filter_col) {
	$filter_col = 'created_date';
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
	$db->where('driver_name', '%' . $search_string . '%', 'like');
	$db->orwhere('driver_channel', '%' . $search_string . '%', 'like');
	$db->orwhere('store_name', '%' . $search_string . '%', 'like');
	$db->orwhere('merchant_name', '%' . $search_string . '%', 'like');
	$db->orwhere('kecamatan', '%' . $search_string . '%', 'like');
	$db->orwhere('kelurahan', '%' . $search_string . '%', 'like');
	$db->orwhere('building_name', '%' . $search_string . '%', 'like');
	$db->orwhere('created_by', '%' . $search_string . '%', 'like');
	$db->orwhere('updated_by', '%' . $search_string . '%', 'like');
}
else if ($date && $date2)
{
	$db->where('created_date', Array ('%' . $date. '%', '%' . $date2 . '%'), 'BETWEEN');

	$tanggal=$db->get('per_transaction_gmv');
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
            <h1 class="page-header">Data Transaksi</h1>
        </div>
        <div class="col-lg-6">
            <div class="page-action-links text-right">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-datamodal"><i class="glyphicon glyphicon-plus"></i> Tambah Data Baru</button>
            </div>
        </div>
    </div>

    <?php include BASE_PATH . '/includes/flash_messages.php';?>

		<!-- Modal add form-->
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

<!-- form -->
						<form method="post" id="addform" action="add_customer.php" enctype="multipart/form-data">

							<div class="form-group hidden">
								<input type="text" class="form-control" name="transaksi_id" value="<?php echo (isset($transaksi_id))?$transaksi_id:'';?>">
							</div>

							<div class="form-group">
								<label for="namadriver">Nama Driver</label>
								<input type="text" class="form-control" name="driver_name" id="namadriver" placeholder="Nama Driver">
							</div>

								<label>Channel Transaksi</label><br>
								<div class="form-group btn-group-toggle" data-toggle="buttons">
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" value="Gojek" autocomplete="off">Gojek
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" value="Grab" autocomplete="off">Grab
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" value="Grab Pesan Sekaligus" autocomplete="off">Grab Pesan Sekaligus
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" value="Walk In" autocomplete="off">Walk In
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" value="E-Commerce" autocomplete="off">E-Commerce
								</label>
								<label class="btn btn-primary">
									<input type="radio" name="driver_channel" value="KKO" autocomplete="off">KKO
								</label>
							</div>
							<br>

							<div class="form-group">
								<label>Nomor Urut</label>
								<input type="number" class="form-control" name="number" id="nourut" placeholder="Nomor Urut" required="required">
							</div>

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

							<label>Jenis Building</label><br>
							<div class="form-group btn-group-toggle" data-toggle="buttons">
							<label class="btn btn-primary">
								<input type="radio" name="building_name" value="Perumahan" autocomplete="off">Perumahan
							</label>
							<label class="btn btn-primary">
								<input type="radio" name="building_name" value="Kantor" autocomplete="off">Kantor
							</label>
							<label class="btn btn-primary">
								<input type="radio" name="building_name" value="Apartemen" autocomplete="off">Apartemen
							</label>
							</div>
							<br>

							<div class="form-group">
								<label>Foto Harga Orderan</label>
								<input name="receipt_picture" type="file" accept="image/*" id="image-source" onchange="previewImage();">
								<img src="https://www.btklsby.go.id/images/placeholder/camera.jpg" id="image-preview" class="img-thumbnail center-block" width="50%">
							</div>

							<div class="form-group">
								<label>Foto Alamat Pengiriman</label>
								<input name="destination_picture" type="file" accept="image/*" id="image-sources" onchange="previewImages();">
								<img src="https://www.btklsby.go.id/images/placeholder/camera.jpg" id="image-previews" class="img-thumbnail center-block" width="50%">
							</div>

		      </div>
		      <div class="modal-footer">
		        <button type="submit" class="btn btn-warning center-block" name="save">Simpan <span class="glyphicon glyphicon-save"></button>
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

  						<label for="example-date-input">Date From</label>
    					<input class="form-control" type="date" value="2021-01-01" name="date1" value="<?php echo xss_clean($date); ?>">
							<label for="example-date-input">To</label>
    					<input class="form-control" type="date" value="2021-01-01" name="date2" value="<?php echo xss_clean($date2); ?>">

            <input type="submit" value="Go" class="btn btn-primary">
        </form>
    </div>
    <hr>
    <!-- //Filters -->


    <div id="export-section">
        <a href="export_customers.php"><button class="btn btn-sm btn-primary">Export to CSV <i class="glyphicon glyphicon-export"></i></button></a>
    </div>

    <!-- Table -->

		<?php
			$users = $db->getOne('last');
			echo "Last Edited By: " .$users['name'];
		?>

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
							<td><img src="<?php echo $row['receipt_picture']; ?>" width="100" height="100"></td>
							<td><img src="<?php echo $row['destination_picture']; ?>" width="100" height="100"></td>
							<td><?php echo xss_clean($row['updated_date']); ?></td>
							<td><?php echo xss_clean($row['created_by']); ?></td>
							<td><?php echo xss_clean($row['updated_by']); ?></td>
                <td>
                    <a href="edit_customer.php?transaksis_id=<?php echo $row['transaksi_id']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="#" class="btn btn-danger delete_btn" data-toggle="modal" data-target="#confirm-delete-<?php echo $row['transaksi_id']; ?>"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>

            <!-- Delete Confirmation Modal -->
            <div class="modal fade" id="confirm-delete-<?php echo $row['transaksi_id']; ?>" role="dialog">
                <div class="modal-dialog modal-sm">
                    <form action="delete_customer.php" method="POST">
                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="modal-title text-center">Hapus Data</h3>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id="del_id" value="<?php echo $row['transaksi_id']; ?>">
                                <p>Apakah Anda Mau Menghapus Data Ini ?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Ya</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
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

<script type="text/javascript">
$(document).ready(function(){
   $("#addform").validate({
       rules: {
            driver_name: {
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

//receiptimage
function previewImage() {
    document.getElementById("image-preview").style.display = "block";
    var oFReader = new FileReader();
     oFReader.readAsDataURL(document.getElementById("image-source").files[0]);

    oFReader.onload = function(oFREvent) {
      document.getElementById("image-preview").src = oFREvent.target.result;
    };
  };

	//destinationimage
	function previewImages() {
	    document.getElementById("image-previews").style.display = "block";
	    var oFReader = new FileReader();
	     oFReader.readAsDataURL(document.getElementById("image-sources").files[0]);

	    oFReader.onload = function(oFREvent) {
	      document.getElementById("image-previews").src = oFREvent.target.result;
	    };
	  };
</script>

<?php include BASE_PATH . '/includes/footer.php';?>
