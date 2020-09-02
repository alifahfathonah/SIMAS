<a href="<?=base_url('document/laporan')?>" class="btn btn-primary btn-sm mb-3">Kembali</a>
<button type="button" class="btn btn-info mb-3 btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg">
  Edit
</button>
<button type="button" class="btn btn-success mb-3 btn-sm" data-toggle="modal" data-target="#modalTambah">
  Tambah Dokumen
</button>
<?php foreach ($dokumenlaporan as $dok):?>

<div class="card card-body border-success">
<h5><b>Detail Dokumen Laporan Kegiatan</b></h5><br>
        <h6><b>Nama Kegiatan </b></h6>
        <?= $dok['id_proposal']?> <br>
        <h6><b>Latar Belakang LPJ </b></h6>
        <?= $dok['lb_laporan']?> <br>
        <h6><b>Tujuan LPJ </b></h6>
        <?= $dok['tujuan_laporan']?> <br>
        <h6><b>laporan jalannya kegiatan </b></h6>
        <?= $dok['lp_jln_kegiatan']?> <br> <br>
        <h6><b>Hasil Kegiatan</b></h6>
        <?= $dok['hasil_kegiatan']?> <br>
        <h6><b>Kendala Kegiatan </b></h6>
        <?= $dok['kendala_kegiatan']?> <br>
        <h6><b>Solusi Kegiatan</b></h6>
        <?= $dok['solusi_kegiatan']?> <br> <br>
        <h6><b>Kesimpulan </b></h6>
        <?= $dok['kesimpulan']?> <br>
        <h6><b>Saran</b></h6>
        <?= $dok['saran']?> <br> <br>
        <h6><b>Arsip Dokumen</b></h6>
        <?php $i=1; foreach($arsip as $ars):?>
        <div class="row ml-2 mt-2">
        <div class="col-1"><?=$i++?></div>
            <div class="col-3"><?=$ars['nama_doc']?></div>
                <div class="col-2">
                    <a href="<?=base_url('document/downloadDocument')?>/<?=$ars['link_file']?>"  class="btn btn-info btn-sm">download</a>
                    <a href="<?=base_url('document/deleteSingleDoc')?>/<?=$ars['id_trans_doc']?>/detailLaporan/<?=$id?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fa fa-remove"></i></a>
                </div>
            </div>
            <?php endforeach?>
        </div>
    <?php endforeach ?>

    <!-- Modal Tambah Dokumen -->

    <?php foreach($arsip as $add):?>
    <div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="<?= base_url('document/addSingleDocument')?>" enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="">Judul Dokumen</label>
                        <input type="hidden" name="backlink" value="detailLaporan">
                        <input type="hidden" name="backid" value="<?= $id?>">
                        <input type="hidden" name="code_id" value="<?= $add['code_id']?>">
                        <input type="text" name="judul[]" placeholder=""class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="">File Dokumen</label>
                        <input type="file" name="arsip[]" class="form-control-file">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach?>
</div>