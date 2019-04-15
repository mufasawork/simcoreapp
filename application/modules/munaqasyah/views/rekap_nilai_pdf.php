<!DOCTYPE html>
<html lang="en"/ dir="ltr">
  <!-- <head> -->
    <meta charset="utf-8">
    <title></title>

    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- <link rel="stylesheet" href="/assets/css/print.css" media="print"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css"> -->
    <link rel="stylesheet" href="/assets/css/gutenberg/gutenberg.css" media="print">
    <link rel="stylesheet" href="/assets/css/gutenberg/themes/modern.min.css" media="print">
    <!-- <link rel="stylesheet" href="https://unpkg.com/hartija---css-print-framework@1.0.0/print.css" type="text/css" media="print" charset="utf-8"> -->
    <!-- Set page size here: A5, A4 or A3 -->
    <!-- Set also "landscape" if you need -->
    <style>
    body {
      font-size: 11px;
    }
    </style>

  </head>
  <body>
      <button class="no-print" onclick="window.print()">print me !</button>

      <p class="w3-center" style="padding-bottom:25px;"><b>REKAP<br>MUNAQASYAH TARTIL METODE <br>SISWA NAMA <br>HARI/TANGGAL : </b></p>

      <table class="w3-table w3-bordered w3-small">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Lembaga</th>

            <!-- start kriteria -->
            <?php foreach($kriteria as $k) :?>
            <th><?= $k->abbr ?></th>
            <?php endforeach?>
            <!-- end kriteria -->

            <th>Jumlah</th>
            <th>Rata2</th>
            <th>Ket</th>
          </tr>
        </thead>
        <tbody>
          <!-- by peserta -->
          <?php $no = 1?>
          <?php foreach($peserta as $p):?>
          <tr>
            <td><?=$no ?></td>
            <td><?=$p->nama_lengkap?></td>
            <td><?=$p->kelas?></td>
            <td>Lembaga</td>

            <!-- nilai kriteria -->
            <?php $count_kriteria = count($kriteria)?>
            <?php foreach($kriteria as $k) :?>
              <?php $v = db_get_row('tm_rekap_nilai', array('peserta_munaqasyah_id' => $p->id_peserta_munaqasyah, 'kriteria_nilai_id' => $k->id_kriteria_nilai))->nilai;?>
              <?php $k_array[$k->id_kriteria_nilai][] = $v; ?>
              <td><?=$v?></td>
            <?php endforeach?>
            <!-- end nilai kriteria  -->
            <?php $j = $this->db->query("SELECT t.peserta_munaqasyah_id, a.kriteria_nilai_id, sum(t.nilai) AS nilai
             FROM tm_nilai_munaqasyah AS t
             LEFT JOIN tm_aspek_nilai AS a ON a.id_aspek_nilai = t.aspek_nilai_id
             WHERE peserta_munaqasyah_id = ".$p->id_peserta_munaqasyah."
            GROUP BY peserta_munaqasyah_id")->row() ?>
            <?php $j_array[] = $j->nilai?>
            <?php $a_array[] =round($j->nilai/$count_kriteria,2)?>
            <?php $s_array[] = $p->status?>
            <td><?=$j->nilai?></td>
            <td><?=round($j->nilai/$count_kriteria,2)?></td>
            <td><?=$p->status?></td>
          </tr>
          <?php $no++?>
          <?php endforeach?>

          <tr style="">
            <td class="w3-center" colspan="4"><b>Tertinggi</b></td>
            <?php foreach($kriteria as $k) :?>
              <td><?= max($k_array[$k->id_kriteria_nilai]) ?> </td>
            <?php endforeach?>
            <td><?= max($j_array)?></td>
            <td><?= max($a_array)?></td>
            <td></td>
          </tr>
          <tr style="">
            <td class="w3-center" colspan="4"><b>Terendah</b></td>
            <?php foreach($kriteria as $k) :?>
              <td><?= min($k_array[$k->id_kriteria_nilai]) ?> </td>
            <?php endforeach?>
            <td><?= min($j_array)?></td>
            <td><?= min($a_array)?></td>
            <td></td>
          </tr>
          <tr style="">
          <td class="w3-center" colspan="4"><b>Rata-rata</td>
          <?php foreach($kriteria as $k) :?>
          <td><?= round(array_sum($k_array[$k->id_kriteria_nilai])/count($k_array[$k->id_kriteria_nilai]),2) ?> </td>
          <?php endforeach?>
          <td><?= array_sum($j_array)/count($j_array) ?></td>
          <td><?= round(array_sum($a_array)/count($a_array),2) ?></td>
          <td></td>
        </tr>
      </tbody>
          <!-- end by peserta -->
      </table>

      <p>Keterangan : Jumlah Peserta : 3 ( <?php foreach(array_count_values($s_array) as $key => $value):?>
        <?php $rekap_peserta[] =  $key." : ".$value?>
      <?php endforeach?> <?= implode($rekap_peserta,", ")?>)
      </p>
      <table class="w3-table">
        <tr>
          <td>Mengetahui,</td>
          <td></td>
        </tr>
        <tr>
          <td>Pentashih MetodeUmmi</td>
          <td>Kepala Sekolah</td>
        </tr>
        <tr>
          <td></td>
          <td>SMP IT AL JIHAD</td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Ust. Pentashih</td>
          <td>Ust. Kepala Sekolah</td>
        </tr>
      </table>



    <?php foreach($kriteria as $k) :?>

    <p class="w3-center page-break" style="padding-bottom:25px;"><b>DAFTAR NILAI <?= strtoupper($k->display_name) ?><br>MUNAQASYAH TARTIL METODE <br>SISWA NAMA <br>HARI/TANGGAL : </b></p>

    <table class="w3-table w3-bordered">
      <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kelas</th>
        <!-- by aspek -->
        <?php $aspek = db_get_all_data('tm_aspek_nilai', array('jenis_munaqasyah_id' => $munaqasyah->jenis_munaqasyah_id, 'kriteria_nilai_id' => $k->id_kriteria_nilai));?>
        <?php foreach ($aspek as $as): ?>
        <th><?= $as->display_name?></th>
        <?php endforeach; ?>
        <th>Jumlah</th>
      </tr>
      <!-- peserta -->
      <?php $no = 1?>
      <?php $ja_array = array();?>
      <?php foreach($peserta as $p):?>
      <tr>
        <td><?=$no?></td>
        <td><?= $p->nama_lengkap?></td>
        <td><?= $p->kelas?></td>
        <!-- nilai by aspek -->
        <?php $nilai_aspek = db_get_all_data('tm_nilai_munaqasyah', array('peserta_munaqasyah_id'=>$p->id_peserta_munaqasyah))?>
        <?php foreach ($nilai_aspek as $na): ?>
          <?php $nilai_peserta[$p->id_peserta_munaqasyah][$na->aspek_nilai_id] = $na->nilai?>
        <?php endforeach; ?>
        <?php foreach ($aspek as $as): ?>
          <?php $ja_array[$p->id_peserta_munaqasyah][] = $nilai_peserta[$p->id_peserta_munaqasyah][$as->id_aspek_nilai] ?>
        <td><?= $nilai_peserta[$p->id_peserta_munaqasyah][$as->id_aspek_nilai] ?></td>
      <?php endforeach?>
        <td><?=array_sum($ja_array[$p->id_peserta_munaqasyah])?></td>
      </tr>
    <?php $no++?>
    <?php endforeach?>

    </table>
    <br>

    <?php endforeach?>

  <?php ?>




</body>
</html>
