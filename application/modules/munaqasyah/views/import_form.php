<div class="row">
    <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <?= message_box('success', TRUE)?>
      <?= message_box('error', TRUE)?>

      <div class="box box-primary">
        <?php echo form_open('','enctype="multipart/form-data"')?>
        <div class="box-body">
          <p>Silahkan download template file <a href="/excel/template_peserta_munaqasyah.xlsx">disini</a> </p>
          <div class="form-group">
            <label for="input_fime">File input</label>
            <input type="file" id="file" name="file">
            <p class="help-block">FIle yang dapat diimport hanya file dengan extension .xlsx.</p>
          </div>
          <div class="">
            <b>PERHATIAN : KETIKA MENGISI TANGGAL_LAHIR FORMAT TANGGAL YANG BENAR ADALAH DD/MM/YYYY contoh 05/10/2017</b><br>
            <b>PERHATIKAN DAN JANGAN SAMPAI SALAH INPUT DATA TANGGAL LAHIR YA</b>
          </div>
        </div>
        <div class="box-footer">
          <button type="submit" name="preview" class="btn btn-primary">Preview</button>
        </div>

        <?php echo form_close()?>
      </div>

      <?php if(isset($_POST['preview'])):?>
      <div class="box box-primary" id="preview_content">
        <div class="box-header">
          <b>Preview Content</b>
        </div>
        <?php echo form_open('munaqasyah/import/save')?>



        <div class="box-body">
              <table class="table table-responsive table-hover">
                <tr>
                  <th colspan="7"></th>
                </tr>
                <tr>
                  <th>Nama Lengkap</th>
                  <th>Tempat Lahir</th>
                  <th>Tanggal Lahir</th>
                  <th>Alamat</th>
                  <th>Kelas</th>
                </tr>

                <?php $numrow = 1;
                $kosong = 0;
                $invalid_date = 0;?>

                <?php foreach($sheet as $row):?>

                <?php $nama_lengkap = $row['A'];
                      $tempat_lahir = $row['B'];
                      $tanggal_lahir = $row['C'];
                      $alamat = $row['D'];
                      $kelas = $row['E'];

                      $allow_date = is_yyyymmdd($tanggal_lahir);


                      if(empty($nama_lengkap) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat) || empty($kelas) ){
              					$kosong++; // Tambah 1 variabel $kosong
              				}
                      ?>
                  <?php if($numrow>1):?>
                  <?php if($allow_date == false){
                    $invalid_date++;
                  }?>
                  <tr>
                    <td <?php if($nama_lengkap == ''){ echo 'class="bg-yellow"'; }?>><?=$nama_lengkap?></td>
                    <td <?php if($tempat_lahir == ''){ echo 'class="bg-yellow"'; }?>><?=$tempat_lahir?></td>
                    <td <?php if($tanggal_lahir == ''){ echo 'class="bg-yellow"'; }?>><?=$tanggal_lahir?></td>
                    <td <?php if($alamat == ''){ echo 'class="bg-yellow"'; }?>><?=$alamat?></td>
                    <td <?php if(empty($kelas)){ echo 'class="bg-yellow"'; }?>><?=$kelas?></td>
                  </tr>
                  <?php endif?>
                  <?php $numrow++?>
                <?php endforeach?>
              </table>


        </div>

        <?php if($kosong > 0 or $invalid_date > 0):?>
          <div class="box-footer" style='color: red;' id='kosong'>
            Semua data belum terisi dengan lengkap, Setidaknya ada <?=$kosong?> baris data yang belum terisi lengkap / <?= $invalid_date?> data tanggal salah formatnya.
          </div>
        <?php else:?>
          <div class="box-footer" style='color: red;' id='kosong'>
            <input type="text" name="code" value="<?=$code?>" hidden >
            <button type="submit" name="import" class="btn btn-primary">Import</button>
          </div>

        <?php endif?>
        <?php echo form_close()?>

      </div>
    <?php endif?>



    </div>

</div>
