<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
</head>
<body>

<?php $i=0?>
<?php foreach($peserta as $p):?>
<?= short_if($i, 0, '' , '<pagebreak>')?>

    <div style="position: absolute; top: 143mm; left: 160mm; width: 100mm;">
       <img src="<?=base_url('assets/uploads/image/').$p->foto?>" style="object-fit= cover; width:110px; height: 150px;" width="110px" alt="">
    </div>
    <div style="height: 65mm">
    </div>
    <div style="text-align:center"><b>No. : <?=$p->no_sertifikat?>/SU/UF - A/<?=$bulan_tahun?></b></div>
    <div class="">
  <table width="100%">
    <tr>
      <td width="30%">Diberikan kepada ananda</td>
      <td width="1%"> : </td>
      <td width="69%"> </td>
    </tr>
    <tr>
      <td>Nama</td>
      <td> : </td>
      <td><?=ucfirst($p->nama_lengkap)?></td>
    </tr>
    <tr>
      <td>Tempat/Tanggal Lahir</td>
      <td> : </td>
      <td><?=$p->tempat_lahir?>, <?=date("d F Y",strtotime($p->tanggal_lahir))?> </td>
    </tr>
    <tr>
      <td>Alamat</td>
      <td> : </td>
      <td><?=$p->alamat?></td>
    </tr>
    <tr>
      <td>Lembaga</td>
      <td> : </td>
      <td><?=$nama_lembaga?></td>
    </tr>
    <tr>
      <td colspan=3>Telah <span class="font-bold">Lulus</span> mengikuti <span class="font-bold"><?=$jenis_munaqasyah?> Al Qur’an Metode Ummi</span> pada tanggal <?=$tanggal_munaqasyah?>.</td>
    </tr>
    <tr>
      <td colspan=3>Semoga Allah SWT senantiasa meridloi dan memberikan ilmu yang bermanfaat. Amin.</td>
    </tr>

  </table>
  <table width="100%">
    <tr>
      <td width="70%"></td>
      <td>
        <div>
          <div>Surabaya, <span style="text-decoration: underline;"><?=$tanggal_hijri?>.</span></div>
          <div><span style="color:white">Surabaya, </span><span><?=$tanggal_masehi?>M.</span></div>
        </div>
      </td>
    </tr>
    <tr>
      <td>Kepala <?=$nama_lembaga?></td>
      <td>Direktur Ummi Foundation</td>
    </tr>
    <tr>
      <td height="200"><?=$kepala_lembaga?></td>
      <td>Drs. H. Masruri, M.Pd.</td>
    </tr>
  </table>

</div>

<pagebreak>

<?php $a = 1 ?>
        <div style="text-align:center;"><b>DAFTAR NILAI MUNAQASYAH</b><br><b style="color:green">TARTIL AL-QURAN</b></div>
        <div style="text-align:center;"><b>METODE UMMI</b></div>

        <div style="padding-top:20px;">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>: <?=ucfirst($p->nama_lengkap)?></td>
                </tr>
                <tr>
                    <td>No. Sertifikat</td>
                    <td>: <?=$p->no_sertifikat?></td>
                </tr>
            </table>
        </div>
        <br>

        <?php $nilai = db_get_all_data('view_rekap_nilai_munaqasyah', array('peserta_munaqasyah_id'=>$p->id_peserta_munaqasyah))?>

        <div class="" style="margin-left:180px">
            <table class="bordered">
            <tr class="a" style="border-bottom:5px solid black;" class="font-bold">
                <th class="a b" width="50">No</td>
                <th class="a b"  width="300">Materi</td>
                <th class="a th" width="70">Nilai</td>
            </tr>
            <?php $i = 1?>
            <?php $count_nilai = count($nilai)?>
            <?php foreach ($nilai as $n): ?>
            <?php $sum[$a][$i] = $n->nilai;?>
            <tr>
                <td class="a center" ><?= $i?>.</td>
                <td class="a" ><?=$n->display_name?></td>
                <td class="a center"><?=$n->nilai?></td>
            </tr>
            <?php $i++?>
            <?php endforeach?>
            <tr style="border-top:5px solid black;">
                <td colspan="2" class="center a"><b>JUMLAH</b></td>
                <td class="center a"><b><?= array_sum($sum[$a])?></b></td>
            </tr>
            <tr>
                <td colspan="2" class="center a"><b>RATA-RATA</b></td>
                <td class="center a"><b><?= round(array_sum($sum[$a]) / $count_nilai,2)?></b></td>
            </tr>
        </table>
        </div>

        <div style="padding-top:50px">
            <table>
                <tr>
                    <td width="450"></td>
                    <td>
                        <div>
                            <div>Surabaya, <span style="text-decoration: underline;"><?=$tanggal_hijri?>.</span></div>
                            <div><span style="color:white">Surabaya, </span><?=$tanggal_masehi?>.</div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>Ketua Ummi Daerah</td>
                    <td>Pentashih Al Qur’an Ummi Foundation</td>
                </tr>
                <tr>
                    <td height="150"><?=$ketua_umda?></td>
                    <td><br><br><br>H. A. Yusuf MS, M.Pd.</td>
                </tr>
            </table>
        </div>


<?php $a++?>
<?php endforeach?>

</body>
</html>
