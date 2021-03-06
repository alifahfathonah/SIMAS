<div>
    <ul class="nav nav-tabs nav-tabs-bottom border-bottom-0">
        <li class="nav-item"><a href="#bottom-divided-tab1" class="nav-link active" data-toggle="tab">Single</a></li>
        <li class="nav-item"><a href="#bottom-divided-tab2" class="nav-link" data-toggle="tab">Multiple</a></li>    
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="bottom-divided-tab1">
            <div class="card">
                <div class="card-body">
                    <legend>
                        TAMBAH DATA SISWA
                    </legend>
                    <form action="<?= base_url('admin/addOsis')?>" method="post" enctype="multipart/form-data">
                    <fieldset class="mb-3">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">NIPD</label>
                            <div class="col-lg-10">
                                <input type="number" class="form-control" placeholder="NIPD" name="nipd" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Siswa</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="Nama Siswa" name="nama" required >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 ">Kelas</label>
                            <div class="col-lg-10">
                                <select class="form-control" name="id_kelas" >
                                <?php foreach($kelas as $kelas):?>
                                    <option value="<?=$kelas['id_kelas']?>"><?=$kelas['kelas']?> <?=$kelas['jurusan']?> <?=$kelas['sub']?></option>
                                <?php endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Nama Ibu</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" placeholder="Nama Ibu" name="ibu" required >
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2">Alamat</label>
                            <div class="col-lg-10">
                                <textarea type="text" class="form-control" rows="4" placeholder="Alamat Lengkap" name="alamat" required ></textarea>
                            </div>
                        </div>
                        
                        
                        </fieldset>

                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit </button>
                        </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="bottom-divided-tab2">
            <div class="card">
                <div class="card-body">
                    <legend>TAMBAH DATA SISWA</legend>
                    <h3><i>Coming Soon</i></h3>
                </div>
            </div>
        </div>
    </div>
</div>

