<style>
.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 15px;
  border-radius: 5px;
  background: #d3d3d3;
  outline: none;
  opacity: 0.7;
  -webkit-transition: .2s;
  transition: opacity .2s;
}

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #4CAF50;
  cursor: pointer;
}

.slider::-moz-range-thumb {
  width: 25px;
  height: 25px;
  border-radius: 50%;
  background: #4CAF50;
  cursor: pointer;
}
</style>

<div class="row">
    <div class="col-sm-12 col-lg-8">
        <div class="box box-primary">
            <div class="box-header">
                <i class="fa fa-user"></i> DATA PESERTA
            </div>
            <div class="box-body">
                <div class="col-sm-12">
                    <dl class="dl-horizontal">
                        <dt>Nama Peserta</dt>
                        <dd><?= $nama_peserta?></dd>
                        <dt>Alamat</dt>
                        <dd><?= $alamat_peserta?></dd>
                        <dt>Tempat, Tanggal Lahir</dt>
                        <dd><?=$tempat_lahir?>, <?=dateFormat($tanggal_lahir)?></dd>
                        <dt>Sekolah / Lembaga</dt>
                        <dd><?= $nama_lembaga?></dd>
                        <dt>Kelas</dt>
                        <dd><?= $kelas?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php $attributes = array('class' => 'form-horizontal', 'id' => 'myform');?>
    <?php echo form_open('',$attributes)?>
    <input name="id_peserta" value="<?= $peserta->id_peserta_munaqasyah?>" hidden>
    <div class="col-sm-12 col-lg-8">
        <div class="box box-primary">
            <div class="box-header">
                <?=$kriteria->display_name?>
            </div>
            <div class="box-body ">
                <?php $aspek_nilai = db_get_all_data('tm_aspek_nilai', array('kriteria_nilai_id' => $kriteria->id_kriteria_nilai))?>
                <?php foreach($aspek_nilai as $a):?>
                    <?php if($method == 'edit' ):?>
                    <?php $value = db_get_row('tm_nilai_munaqasyah', array('peserta_munaqasyah_id' => $peserta->id_peserta_munaqasyah, 'aspek_nilai_id' =>$a->id_aspek_nilai))->nilai;?>
                        <div class="form-group">
                            <label for="<?= $a->aspek?>" class="col-sm-2 control-label"><?= $a->display_name?></label>
                            <div class="col-sm-8">
                                <input type="range" name="nilai[]" value="<?=$value?>" class="slider" min="0" max="<?= $a->max?>" step="0.5" id="<?= $a->aspek?>" placeholder="">
                                <input name="aspek_nilai_id[]" value="<?= $a->id_aspek_nilai ?>" hidden>
                            </div>
                            <div class="col-sm-2">
                                <span id="val-<?= $a->aspek?>"></span>
                            </div>
                        </div>
                    <?php else:?>
                        <div class="form-group">
                            <label for="<?= $a->aspek?>" class="col-sm-2 control-label"><?= $a->display_name?></label>
                            <div class="pt-4 col-sm-8 col-xs-10">
                                <input type="range" name="nilai[]" value="0" class="slider" min="0" max="<?= $a->max?>" step="0.5" id="<?= $a->aspek?>" placeholder="">
                                <input name="aspek_nilai_id[]" value="<?= $a->id_aspek_nilai ?>" hidden>
                            </div>
                            <div class="pt-2 col-sm-2 col-xs-2">
                                <span id="val-<?= $a->aspek?>">0</span>
                            </div>
                        </div>

                    <?php endif?>

                <?php endforeach?>
                <div>
                  <label for="sum" class="col-sm-2 control-label">Total </label>
                  <div class="pt-4 col-sm-8 col-xs-10">
                    <span id="sum"></span>
                  </div>
                </div>

            </div>
            <div class="box-footer">
                <a href="javascript:history.back()" class="btn btn-default btn-flat">Kembali</a>
                <input class="btn btn-success btn-flat float-right" type="submit">
            </div>
        </div>
    </div>
    </form>
</div>
<div id="demo"></div>

<script>
<?php foreach($aspek_nilai as $a):?>
document.getElementById("val-<?= $a->aspek?>").innerHTML = document.getElementById("<?= $a->aspek?>").value; // Display the default slider value

// Update the current slider value (each time you drag the slider handle)
document.getElementById("<?= $a->aspek?>").oninput = function() {
    document.getElementById("val-<?= $a->aspek?>").innerHTML = this.value;
}

<?php endforeach?>

$('.slider').each(function(){
    $(this).change(function(){
        calculateSum();
    });
});

function calculateSum() {
  var sum = 0;
  $('.slider').each(function(){
    if(!isNaN(this.value) && this.value.length!=0) {
				sum += parseFloat(this.value);
			}
  });
  document.getElementById("sum").innerHTML = sum;
}

</script>
