<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Rincian_SPKL_validasi.xls");

function getBulanIndo($bulan) {
    $arr_bulan = array(
        "1" => "JANUARI",
        "2" => "FEBRUARI", 
        "3" => "MARET",
        "4" => "APRIL",
        "5" => "MEI",
        "6" => "JUNI",
        "7" => "JULI",
        "8" => "AGUSTUS",
        "9" => "SEPTEMBER",
        "10" => "OKTOBER",
        "11" => "NOVEMBER",
        "12" => "DESEMBER"
    );
    return $arr_bulan[$bulan];
}
$tgl=date('d');
// Pembulatan: > .5 ke atas, .5 atau kurang ke bawah
function pembulatan_otomatis($angka){
    $bawah = floor($angka);
    $pecahan = $angka - $bawah;
    if($pecahan > 0.5){
        return $bawah + 1; // ke atas
    }
    return $bawah; // termasuk pecahan == 0.5 atau < 0.5 -> ke bawah
}
?>
<table border="0" style="width: 89%;">
    <tr>
        <th colspan="11" align="center" style="font-weight: bold;">RINCIAN PEMBAYARAN  KERJA LEBIH  KARYAWAN PT SEBRA CIPTA MANDIRI</th>
    </tr>
    <tr>
        <th colspan="11" align="center" style="font-weight: bold;">BULAN <?php echo getBulanIndo($bulan) . " " . $tahun; ?></th>
    </tr>
    <tr><th colspan="11"></th></tr>
</table>
<table border="1">
  <thead>
    <tr>
      <th rowspan="2">NO</th>
      <th rowspan="2">NAMA</th>
      <th rowspan="2">NIK</th>
      <th rowspan="2">JABATAN</th>
      <th rowspan="2">UNIT KERJA</th>
      <th colspan="4">KERJA LEBIH</th>
      <th rowspan="2" style="width: 100px;">UANG MAKAN LEMBUR</th>
      <th rowspan="2" style="width: 100px;">TOTAL KERJA LEBIH</th>
    </tr>
    <tr>
      <th>TANGGAL</th>
      <th>JENIS LEMBUR</th>
      <th>JUMLAH JAM</th>
	  <th>TOTAL</th>
    </tr>
  </thead>
    <tbody>
        <?php 
        $no = 1;
		$tlembur=0;

		foreach($data as $row)
		{
        	if($row->statusHari=="Kerja")
			{
				$hari="Hari Biasa";
			}
				else
			{	
				$hari="Hari Libur / Off";
			}
		?>
        <tr>
            <td><?php echo $no++; ?></td>
			<td><?php echo $row->namaPegawai; ?></td>
			<td><?php echo $row->nipBaru; ?></td>
			<td><?php echo $row->jabatan; ?></td>
			<td><?php echo $row->nama; ?></td>
			<td><?php echo $row->tglLembur; ?></td>
			<td><?php echo $hari; ?></td>
			<td><?php echo $row->jmlJam; ?></td>
            <td><?php echo pembulatan_otomatis($row->nilai); ?></td>
            <td><?php echo pembulatan_otomatis($row->uangMakan); ?></td>
			<?php
            $t=pembulatan_otomatis($row->nilai) + pembulatan_otomatis($row->uangMakan);
			?>
			<td><?php echo $t; ?></td>
        </tr>
        <?php 
		$tlembur += $t;
		}
		?>
		<tr>
			<td colspan="10" align="center"><b>Total</b></td>
            <td><b><?php echo pembulatan_otomatis($tlembur); ?></b></td>
		</tr>
    </tbody>
</table>
<p></p>
<p></p>
<table border="0" style="width: 80%;">
    <tr>
        <td width="10"></td>
		<td colspan="7" align="right" style="width: 60%;">&nbsp;</td>
		<td colspan="4" align="left" style="font-weight: bold;">Kepanjen <?php echo $tgl." ".getBulanIndo($bulan) . " " . $tahun;?></td>
    </tr>
</table>
<table border="0" style="width: 80%;">
    <tr>
        <td width="10"></td>
		<td colspan="7" align="left" style="font-weight: bold;text-decoration: underline;">Mengetahui</td>
		<td colspan="4" align="center" style="font-weight: bold;">Dibuat Oleh</td>
    </tr>
	<tr height="100">
        <td width="10"></td>
		<td colspan="7" align="left" style="font-weight: bold;"></td>
		<td colspan="4" align="center" style="font-weight: bold;"></td>
    </tr>
	<tr>
        <td width="10"></td>
		<td colspan="7" align="left" style="font-weight: bold;text-decoration: underline;">Ummi Hani</td>
		<td colspan="4" align="center" style="font-weight: bold;">Rossi Agustia</td>
    </tr>
	<tr>
        <td width="10"></td>
		<td colspan="7" align="left" style="font-weight: bold;">Direktur</td>
		<td colspan="4" align="center" style="font-weight: bold;">Staff Administrasi</td>
    </tr>
</table>


