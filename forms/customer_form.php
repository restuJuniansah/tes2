<fieldset>
    <div class="form-group">
        <label>Nama Driver</label>
          <input type="text" name="driver_name" value="<?php echo htmlspecialchars($customer['driver_name']); ?>" class="form-control" required="required">
    </div>

    <label>Channel Transaksi</label><br>
    <div class="form-group">
      <label class="radio-inline">
        <input type="radio" name="driver_channel" value="Gojek" <?php echo ($customer['driver_channel'] =='Gojek') ? "checked": "" ; ?>>Gojek
      </label>
      <label class="radio-inline">
        <input type="radio" name="driver_channel" value="Grab" <?php echo ($customer['driver_channel'] =='Grab') ? "checked": "" ; ?>>Grab
      </label>
      <label class="radio-inline">
        <input type="radio" name="driver_channel" value="Grab Pesan Sekaligus" <?php echo ($customer['driver_channel'] =='Grab Pesan Sekaligus') ? "checked": "" ; ?>>Grab Pesan Sekaligus
      </label>
      <label class="radio-inline">
        <input type="radio" name="driver_channel" value="Walk In" <?php echo ($customer['driver_channel'] =='Walk In') ? "checked": "" ; ?> autocomplete="off">Walk In
      </label>
      <label class="radio-inline">
        <input type="radio" name="driver_channel" value="E-Commerce" <?php echo ($customer['driver_channel'] =='E-Commerce') ? "checked": "" ; ?> autocomplete="off">E-Commerce
      </label>
      <label class="radio-inline">
        <input type="radio" name="driver_channel" value="KKO" <?php echo ($customer['driver_channel'] =='KKO') ? "checked": "" ; ?> autocomplete="off">KKO
      </label>
    </div>

    <div class="form-group">
      <label>Nama Toko</label>
      <input type="text" class="form-control" name="store_name" value="<?php echo htmlspecialchars($customer['store_name']); ?>">
    </div>

    <div class="form-group">
      <label>Nama Merchant</label>
      <input type="text" class="form-control" name="merchant_name" value="<?php echo htmlspecialchars($customer['merchant_name']); ?>">
    </div>

    <div class="form-group">
      <label>Total Harga di Aplikasi</label>
      <input type="number" class="form-control" name="gmv" value="<?php echo htmlspecialchars($customer['gmv']); ?>">
    </div>

    <div class="form-group">
      <label>Kecamatan</label>
      <input type="text" class="form-control" name="kecamatan" value="<?php echo htmlspecialchars($customer['kecamatan']); ?>">
    </div>

    <div class="form-group">
      <label>Kelurahan</label>
      <input type="text" class="form-control" name="kelurahan" value="<?php echo htmlspecialchars($customer['kelurahan']); ?>">
    </div>

    <label>Jenis Building</label><br>
    <label class="radio-inline">
      <input type="radio" name="building_name" value="Perumahan" <?php echo ($customer['building_name'] =='Perumahan') ? "checked": "" ; ?>>Perumahan
    </label>
    <label class="radio-inline">
      <input type="radio" name="building_name" value="Kantor" <?php echo ($customer['building_name'] =='Kantor') ? "checked": "" ; ?>>Kantor
    </label>
    <label class="radio-inline">
      <input type="radio" name="building_name" value="Apartemen" <?php echo ($customer['building_name'] =='Apartemen') ? "checked": "" ; ?>>Apartemen
    </label>

    <div class="form-group">
      <label>Foto Harga Orderan</label>
      <input name="receipt_picture" type="file" accept="image/*" id="image-source" onchange="previewImage();">
      <img src="<?php echo $customer['receipt_picture']; ?>" id="image-preview" class="img-thumbnail center-block" width="50%">
    </div>

    <div class="form-group">
      <label>Foto Alamat Pengiriman</label>
      <input name="destination_picture" type="file" accept="image/*" id="image-sources" onchange="previewImages();">
      <img src="<?php echo $customer['destination_picture']; ?>"  id="image-previews" class="img-thumbnail center-block" width="50%">
    </div>

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Simpan <span class="glyphicon glyphicon-save"></span></button>
        <a href="customers.php" class="btn btn-danger delete_btn">Batal <i class="glyphicon glyphicon-remove-sign"></i></a>
    </div>
</fieldset>

<script type="text/javascript">
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
