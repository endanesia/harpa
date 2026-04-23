<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Tanda Terima_SPKL_validasi.xls");
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
// Pembulatan otomatis: pecahan > 0.5 dibulatkan ke atas, 0.5 atau kurang ke bawah
function pembulatan_otomatis($angka){
    $bawah = floor($angka);
    $pecahan = $angka - $bawah;
    if($pecahan >= 0.5){
        return $bawah + 1;
    }
    return $bawah;
}
?>
<table border="0" style="width: 89%;">
    <tr>
        <th colspan="11" align="center" style="font-weight: bold;">TANDA TERIMA PEMBAYARAN KERJA LEBIH KARYAWAN </th>
    </tr>
    <tr>
        <th colspan="11" align="center" style="font-weight: bold;">BULAN <?php echo getBulanIndo($bulan) . " " . $tahun; ?></th>
    </tr>
    <tr><th colspan="11"></th></tr>
</table>
<table border="1">
  <thead>
    <tr>
      <th>NO</th>
      <th>NAMA</th>
      <th>NIK</th>
      <th>JABATAN</th>
      <th>UNIT KERJA</th>
      <th>KERJA LEBIH</th>
      <th>NOREK</th>
      <th colspan="2">TANDA TANGAN</th>
    </tr>
  </thead>
    <tbody>
        <?php 
        $no = 1;
		$tlembur=0;

		foreach($data as $row)
		{
        ?>
        <tr>
            <td><?php echo $no; ?></td>
			<td><?php echo $row->namaPegawai; ?></td>
			<td><?php echo $row->nipBaru; ?></td>
			<td><?php echo $row->jabatan; ?></td>
			<td><?php echo $row->nama; ?> </td>
            <td style="text-align: right;"><?php echo floor($row->Total); ?></td>
			<td><?php echo $row->norek; ?></td>
			<td style="width: 100px;text-align: right;"><?php echo '<b>'.$no++.'</b>'; ?></td>
			<td style="width: 100px;text-align: right;"><?php echo '<b>Transfer</b>'; ?></td>
        </tr>
        <?php 
		$tlembur += $row->Total;
		}
		?>
		<tr>
			<td colspan="5" align="center"><b>Total</b></td>
            <td style="text-align: right;"><b><?php echo floor($tlembur); ?></b></td>
			<td><b></b></td>
			<td><b></b></td>
			<td><b></b></td>
		</tr>
    </tbody>
</table>
<p></p>
<p></p>
<table border="0">
    <tr>
        <td style="width: 750px;"> </td>
		<td align="center" style="font-weight: bold;">Kepanjen <?php echo $tgl." ".getBulanIndo($bulan) . " " . $tahun;?></td>
    </tr>
</table>
<table border="0" style="width: 80%;">
    <tr>
        <td width="10"></td>
		<td colspan="7" align="left" style="font-weight: bold;">Mengetahui</td>
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


