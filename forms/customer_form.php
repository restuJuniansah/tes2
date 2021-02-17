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

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Save <span class="glyphicon glyphicon-send"></span></button>
    </div>
</fieldset>
