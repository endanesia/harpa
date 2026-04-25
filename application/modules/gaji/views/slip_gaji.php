<style>
    @page {
        margin: 20px;
    }

    .table {
        width: 800px;
        border: 2px solid #000;
        border-collapse: collapse;
        font-family: Verdana, Geneva, Tahoma, sans-serif
    }

    .gp {
        font-size: 24pt;
        font-weight: bold;
        color: red;
        margin-left: 35px !important;
        text-transform: uppercase;
        text-shadow: 1px 3px 5px rgba(0, 0, 0, 0.8);
    }

    .gp2 {
        font-size: 24pt;
        font-weight: bold;
        color: white;
        padding-left: 15px;
        text-transform: uppercase;
        text-shadow: 1px 3px 5px rgba(0, 0, 0, 0.8);
    }

    .nama_pt {
        font-size: 22pt;
        font-weight: bold;
        text-transform: uppercase;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .nama_pt2 {
        font-size: 18pt;
        font-weight: bold;
        text-transform: uppercase;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .nominal {
        text-align: right;
        display: block;
        width: 300px;
        background-color: #b8b9ba;
    }
</style>
<table class="table">
    <thead>
        <tr>
            <td colspan="2" style="background: #97b7e8;">
                <table>
                    <tr>
                        <td width="450px">
                            <div class="gp">&nbsp;Slip Gaji Periode</div>
                            <div class="gp2">&nbsp;<?php echo isset($bulan) ? bulan($bulan) : bulan(date('m')); ?> <?php echo isset($tahun) ? $tahun : date('Y'); ?></div>
                        </td>
                        <td width="350px" style="background: #97b7e8;">
                            <table class="content_header_tabel">
                                <tr>
                                    <td style="width:50px;">&nbsp;</td>
                                    <td style="text-align: right;"><img style="margin: auto;" src="<?php echo base_url('assets/imgs/' . (isset($provider) ? $provider->logo : 'logo_reyusam.png')); ?>" width="280px" alt="logo" /></td>
                                </tr>

                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="width: 150px; padding:5px;">Nama</td>
                        <td style="width: 280px; padding:5px;">: <?php echo isset($pegawai) ? $pegawai->namaPegawai : ""; ?></td>
                        <td style="width: 150px; padding:5px;">Rekening Bank</td>
                        <td style="width: 200px; padding:5px;">: <?php echo isset($pegawai) ? $pegawai->nama_bank : ""; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 150px; padding:5px;">Jabatan</td>
                        <td style="width: 280px; padding:5px;">: <?php echo isset($pegawai) ? $pegawai->jabatan : ""; ?></td>
                        <td style="width: 150px; padding:5px;">No. Rekening </td>
                        <td style="width: 200px; padding:5px;">: <?php echo isset($pegawai) ? $pegawai->norek : ""; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 150px; padding:5px;">Divisi</td>
                        <td style="width: 280px; padding:5px;">: <?php echo isset($pegawai) ? $pegawai->jabatan : ""; ?></td>
                        <td style="width: 150px; padding:5px;">&nbsp;</td>
                        <td style="width: 200px; padding:5px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="width: 150px; padding:5px;">Project</td>
                        <td style="width: 280px; padding:5px;">: <?php echo isset($unit) ? $unit->nama : ""; ?></td>
                        <td style="width: 150px; padding:5px;"></td>
                        <td style="width: 200px; padding:5px;"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="border-collapse: collapse;margin-top:10px;">
                    <tr>
                        <td style="width: 430px;letter-spacing: 3px; font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000;">PENERIMAAN</td>
                        <td style="width: 400px;letter-spacing: 3px; font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000;">POTONGAN</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="border-collapse: collapse;">
                    <tr>
                        <td style="width: 400px; vertical-align:top;">
                            <table style="border-collapse: collapse; font-size:10pt;width:90%;">
                                <tr>
                                    <td style="width: 170px; padding:6px 4px;">Gaji Pokok</td>
                                    <td style="width: 50px;">: Rp.</td>
                                    <td style="width: 250px; padding:6px 4px;text-align:right;"><?php echo isset($gaji) ? number_format($gaji->gaji_pokok, 0, ',', '.') : ''; ?></td>
                                </tr>
                                <?php
                                $tunjangan = 0;
                                $total_penerimaan = 0;
                                if (isset($pendapatan) && count($pendapatan) > 0) {
                                    foreach ($pendapatan as $pdpt) {
                                        $tunjangan = $tunjangan + $pdpt->jml;
                                        echo '
                                        <tr>
                                            <td style="width: 170px; padding:6px 4px;">' . $pdpt->nama_tunjangan . '</td>
                                            <td style="width: 50px;">: Rp.</td>
                                            <td style="width: 250px; padding:6px 4px;text-align:right;">' . number_format($pdpt->jml, 0, ',', '.') . '</td>
                                        </tr>';
                                    }
                                    $total_penerimaan = $gaji->gaji_pokok + $tunjangan;
                                }
                                ?>
                            </table>
                        </td>
                        <td style="width: 400px;vertical-align:top;">
                            <table style="border-collapse: collapse; font-size:10pt;">
                                <?php
                                $jmlpotongan = 0;
                                if (isset($potongan) && count($potongan) > 0) {
                                    foreach ($potongan as $ptng) {
                                        $jmlpotongan = $jmlpotongan + $ptng->jml;
                                        echo '
                                        <tr>
                                            <td style="width: 170px; padding:6px 4px;">' . $ptng->nama_potongan . '</td>
                                            <td style="width: 50px;">: Rp.</td>
                                            <td style="width: 250px; padding:6px 4px;text-align:right;">' . number_format($ptng->jml, 0, ',', '.') . '</td>
                                        </tr>';
                                    }
                                } else {
                                    echo '
                                        <tr>
                                            <td style="width: 170px; padding:6px 4px;">Pot. Lain-lain</td>
                                            <td style="width: 50px;">: Rp.</td>
                                            <td style="width: 250px; padding:6px 25px 6px;text-align:right;">-</td>
                                        </tr>';
                                }
                                ?>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table style="border-collapse: collapse;margin-top:10px;">
                    <tr>
                        <td style="width: 150px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000;">Total Penerimaan</td>
                        <td style="width: 50px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000;">: Rp.</td>
                        <td style="width: 160px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000; text-align:right;"><?php echo number_format($total_penerimaan, 0, ',', '.'); ?></td>
                        <td style="width: 35px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000; text-align:right;">&nbsp;</td>

                        <td style="width: 150px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000;">Total Potongan</td>
                        <td style="width: 50px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000;">: Rp.</td>
                        <td style="width: 200px;font-weight:bold; padding:5px;background:#b8b9ba;border-top:1px dotted #000;border-bottom:1px dotted #000; text-align:right; padding:6px 25px 6px;"><?php echo $jmlpotongan == 0 ? "-" : number_format($jmlpotongan, 0, ',', '.'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="width: 25%; vertical-align:top; padding-top:10px;">
                <table style="border-collapse: collapse; font-size:12pt;background:#aeccfc;font-weight:bold;">
                    <tr>
                        <td style="width: 150px; padding:10px 5px; text-align:center; border-left:2px solid #000; border-top:2px solid #000; border-bottom:2px solid #000;">Jumlah Dibayar</td>
                        <td style="width: 50px; border-top:2px solid #000; border-bottom:2px solid #000;">: Rp.</td>
                        <td style="width: 200px; padding:5px;text-align:right;border-right:2px solid #000; border-top:2px solid #000; border-bottom:2px solid #000;">
                            <?php $jml_bayar = $total_penerimaan - $jmlpotongan;
                            echo  number_format($jml_bayar, 0, ',', '.'); ?>
                        </td>
                    </tr>
                </table>
            </td>
            <td></td>
        </tr>

    </tbody>
</table>