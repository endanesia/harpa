<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_SPGJ_validasi.xls");

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
?>
<table>
    <tr>
        <td colspan="10" align="center" style="font-weight: bold;">RINCIAN PEMBAYARAN PENGGANTI KARYAWAN DISPENSASI & SAKIT YANG BERHALANGAN HADIR</td>
    </tr>
    <tr>
        <td colspan="10" align="center" style="font-weight: bold;">BULAN <?php echo getBulanIndo($bulan) . " " . $tahun; ?></td>
    </tr>
    <tr><td colspan="10"></td></tr>
</table>

<table border="1">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIK</th>
            <th>Unit Kerja</th>
            <th>Jabatan</th>
            <th>Menggantikan</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
            <th>Tgl Validasi</th>
            <th>Jumlah Hari</th>
            <th>Nilai</th>
            <th>No Rekening</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        foreach($data as $row):
            //if ($row->status == 1) continue; // Skip if status is not 0
            $pegawai_diganti = $this->ganti_jaga_model->pegawai_id($row->idp_yg_diganti)->row();
            $unit = $this->ganti_jaga_model->unit_kerja_id($row->skpd)->row();
            $jabatan = $this->ganti_jaga_model->jabatan_id($row->idJabatan)->row();
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row->namaPegawai; ?></td>
            <td><?php echo $row->nipBaru; ?></td>
            <td><?php echo $unit->nama; ?></td>
            <td><?php echo $jabatan->namaJabatan; ?></td>
            <td><?php echo isset($pegawai_diganti->namaPegawai) ? $pegawai_diganti->namaPegawai : ''; ?></td>
            <td><?php echo $row->alasan; ?></td>
            <td><?php echo date('d-m-Y', strtotime($row->tglLembur)); ?></td>
            <td><?php echo date('d-m-Y', strtotime($row->tgl_validasi)); ?></td>
            <td>1</td>
            <td><?= $row->tunjangan ?></td>
            <td><?php echo $row->norek; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>