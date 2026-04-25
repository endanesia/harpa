<div class="row">
    <div class="col-sm-12 col-md-12 text-md-right">
        <a href="<?php echo site_url('gaji/hitung'); ?>" class="btn btn-warning"><i class="fa fa-chevron-circle-left"></i> Kembali</a>
    </div>
</div>
<br />
<?php
if ($this->session->flashdata('errMsg')) {
    echo '<div class="alert alert-danger">' . $this->session->flashdata('errMsg') . '</div>';
} else {
?>
    <div class="alert alert-warning" id="alert_process">Mohon tidak menutup halaman ini sampai Proses Selesai. <span class="fa fa-spinner fa-spin"></span> <strong><span id="info_proses"></strong></span><br />
        <em>KETERANGAN: Proses akan meng-UPDATE data, bila data sudah tersedia.</em>
    </div>
    <div class="alert alert-success h4" style="display: none;" id="alert_success">Data berhasil import sebanyak <span id="jumlah_success_import"></span></div>
    <div class="alert alert-danger h4" style="display: none;" id="alert_failed">Data gagal sebanyak <span id="jumlah_failed_import"></span></div>
    <div class="card card-body">
        <?php

        if (isset($data_import) && $data_import != "") {
            echo '<table class="table table-striped">';
            echo '<tr><td style="width:20px;">No</td><td style="width:100px;">ID</td><td style="width:300px;">Nama</td><td>Status Import</td></tr>';
            echo '<tbody id="data_import">';
            $no = 1;
            foreach ($data_import as $i) {
                $id = preg_replace('/\s+/', '', $i['nip_lama']);
                echo '<tr id="tr_' . $id  . '" data-id="' . $id  . '" data-gaji="' . $i['nominal_gaji'] . '" data-lembur="' . $i['nominal_lembur'] . '" data-bulan="' . $i['bulan'] . '" data-tahun="' . $i['tahun'] . '" >';
                echo '<td>' . $no . '.</td>';
                echo '<td>' . $id  . '</td>';
                echo '<td>' . $i['nama'] . '</td>';
                echo '<td><span id="preview_' . $id  . '"><span class="fa fa-spinner fa-spin"></span> Proses...</span></td>';
                echo '</tr>';
                $no++;
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<div class="alert">Tidak ada data pada file excel.</div>';
        }
        ?>
    <?php }; ?>
    </div>
    <script>
        var tracker = [];
        var proses = 0;
        var jumlah = 0;
        var success_import = 0;
        var gagal_import = 0;

        $('#data_import tr').each(function() {
            tracker.push($(this).data('id'));
            jumlah++;
        });

        tracker.reverse();
        setTimeout(makeRequest(tracker), 1000);


        function makeRequest(tracker) {
            var id = tracker.pop();
            var gaji = $("#tr_" + id).data('gaji');
            var lembur = $("#tr_" + id).data('lembur');
            var bulan = $("#tr_" + id).data('bulan');
            var tahun = $("#tr_" + id).data('tahun');
            if (id != "") {
                $.ajax({
                    url: "<?php echo site_url('gaji/proses_import_gaji'); ?>",
                    type: "POST",
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    dataType: "html",
                    data: "id=" + id + "&bulan=" + bulan + "&tahun=" + tahun + "&gaji=" + gaji + "&lembur=" + lembur,
                    beforeSend: function() {
                        proses++;
                        $("#info_proses").html(proses + "/" + jumlah);
                    },
                    success: function(data) {
                        // use returned result here                      
                        console.log(data);
                        obj = JSON.parse(data);
                        if (obj.status == 'OK') {
                            success_import++;
                            $("#preview_" + id).html('<span class="text-success"><i class="fa fa-check-circle"></i> ' + obj.message + '</span>');
                        } else {
                            gagal_import++;
                            $("#preview_" + id).html('<span class="text-danger"><i class="fa fa-times-circle"></i> ' + obj.message + '</span>');
                        }

                    },
                    complete: function() {
                        if (tracker.length) {
                            makeRequest(tracker);
                        } else {

                            $("#alert_process").fadeOut();
                            if (gagal_import > 0) {
                                $("#alert_failed").fadeIn();
                                $("#jumlah_failed_import").html(gagal_import + ' record');
                            }
                            if (success_import > 0) {
                                $("#alert_success").fadeIn();
                                $("#jumlah_success_import").html(success_import + ' record');
                            }

                        };
                    }
                });
            }
        }
    </script>