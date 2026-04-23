<?php
$filename = isset($title) ? $title : 'Template Jadwal Shift';
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename=' . str_replace(' ', '_', $filename) . '.xls');
header('Pragma: no-cache');
header('Expires: 0');

$thn = intval($tahun);
$bln = str_pad((string) intval($bulan), 2, '0', STR_PAD_LEFT);

$hariKolom = array('21', '22', '23', '24', '25', '26', '27', '28');
if ($bln == '03' && ($thn % 4 == 0)) {
	$hariKolom[] = '29';
}
if ($bln != '03') {
	$hariKolom[] = '29';
	$hariKolom[] = '30';
	if ($bln == '01' || $bln == '02' || $bln == '04' || $bln == '06' || $bln == '08' || $bln == '09' || $bln == '11') {
		$hariKolom[] = '31';
	}
}
for ($i = 1; $i <= 20; $i++) {
	$hariKolom[] = str_pad((string) $i, 2, '0', STR_PAD_LEFT);
}
?>
<table border="1">
	<tr>
		<td colspan="<?= count($hariKolom) + 2; ?>"><b><?= $filename; ?></b></td>
	</tr>
	<tr>
		<td colspan="<?= count($hariKolom) + 2; ?>">
			Unit: <?= isset($unit->nama) ? $unit->nama : '-'; ?>,
			Jabatan: <?= isset($jabatan->namaJabatan) ? $jabatan->namaJabatan : '-'; ?>,
			Periode: <?= $bln; ?>/<?= $thn; ?>
		</td>
	</tr>
	<tr>
		<td><b>NIP</b></td>
		<td><b>Nama Pegawai</b></td>
		<?php foreach ($hariKolom as $h) { ?>
			<td><b><?= intval($h); ?></b></td>
		<?php } ?>
	</tr>
	<?php foreach ($pegawai as $p) { ?>
		<tr>
			<td><?= $p->nipBaru; ?></td>
			<td><?= $p->namaPegawai; ?></td>
			<?php foreach ($hariKolom as $h) { ?>
				<td></td>
			<?php } ?>
		</tr>
	<?php } ?>
</table>
