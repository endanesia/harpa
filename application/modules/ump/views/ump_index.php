<div class="card card-body">
    <div class="row">
        <div class="col-sm-12 col-md-12 text-md-right">
            <a onClick="ClearForm()" id="add" title="Tambah Data" class="btn btn-primary text-white btn-sm" data-toggle="modal" data-target="#modalView_input"><span class="fa fa-plus" ></span> Tambah Data</a>
            <a id="refresh" title="Refresh" onclick="window.location.reload();" class="btn btn-info text-white btn-sm"><span class="fa fa-refresh"></span> Refresh</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped" id="example1">
                <thead>
                    <tr>
                        <th>Tahun</th>
                        <th>Upah Rata-rata</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dt as $row) { ?>
                        <tr>
                            <td><?= $row->tahun ?></td>
                            <td><?= number_format($row->nilai_ump,0,',','.') ?></td>
                            <td>
                                <!-- modal form untuk edit data -->
                                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalEdit<?php echo $row->id;?>" data-backdrop="static">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle_ump">Edit Data UMP</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="<?= site_url('ump/Update_ump/'.$row->id) ?>" method="post">
                                                <input type="hidden" name="id" id="id">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">Tahun</div>
                                                            <div class="col-md-4">
                                                                <input type="number" name="tahun" class="form-control" id="tahun" value="<?=$row->tahun;?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="row">
                                                            <div class="col-md-3">Upah Rata-rata</div>
                                                            <div class="col-md-4">
                                                                <input type="text" name="nilai_ump" class="form-control" value="<?=$row->nilai_ump;?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Ubah Data</button>
                                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-gears"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="Dropdown Menu">
                                        <a href="" class="dropdown-item edit" title="edit data" data-toggle="modal" data-target="#modalEdit<?php echo $row->id; ?>">
                                            <i class="fa fa-pencil"></i> Edit
                                        </a>
                                        <a href="<?= site_url('ump/Hapus/'.$row->id) ?>" class="dropdown-item hapus" title="hapus data" >
                                            <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal form untuk input data -->
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Modal label" aria-hidden="true" id="modalView_input" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle_ump">Input Data UMP</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= site_url('ump/Simpan') ?>" method="post">
                <input type="hidden" name="id" id="id" value="0">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">Tahun</div>
                            <div class="col-md-4">
                                <input type="number" name="tahun" class="form-control" id="tahun" value="<?php echo date('Y'); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">Upah Rata-rata</div>
                            <div class="col-md-4">
                                <input type="text" name="nilai_ump" class="form-control" id="nilai_ump">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm"><span class="fa fa-check"></span> Simpan</button>
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><span class="fa fa-times"></span> Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function GetData(id) {
        $.ajax({
            url: "<?= site_url('ump/GetUmp') ?>",
            type: 'POST',
            dataType: 'json',
            data: {id: id},
            success: function(data) {
                $('#tahun').val(data.tahun);
                $('#nilai_ump').val(data.nilai_ump);
                $('#id').val(data.id);
            }
        });
    }
    function ClearForm() {
        $('#tahun').val('<?php echo date('Y'); ?>');
        $('#nilai_ump').val('');
        $('#id').val(0);
    }
</script>