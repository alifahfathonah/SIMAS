<h3><i class="fa fa-info-circle mr-1"></i>Dashbord Mutu Sekolah</h3>
<div class="card card-body border-info mt-2">
    <form action="" id="filterRentang" method="get">
        <div class="form-group my-auto">
            <!-- <label for="">Filter Tahun Akademik</label> -->
            <div class="form-check form-check-switchery">
                <label class="form-check-label">
                    <input type="checkbox" name="rentang" id="useRentang" class="form-check-input-switchery" data-fouc 
                    <?php if(isset($_GET['rentang'])&&$_GET['rentang']=='on'){echo 'checked';};?>
                    >
                    Rentang Tahun
                </label>
            </div>
            <div class="row mt-3">
                <div class="col-md-2">
                    <select name="dari" id="" class="form-control">
                        <option value="semua">semua tahun</option>
                        <option value="2018/2019">2018/2019</option>
                        <option value="2019/2020">2019/2020</option>
                    </select>
                </div>
                <?php if(isset($_GET['rentang'])&&$_GET['rentang']=='on'){?>
                <span class=" my-auto"> sampai </span>
                <div class="col-md-2">
                    <select name="sampai" id="" class="form-control">
                        <option value="semua">semua tahun</option>
                        <option value="2018/2019">2018/2019</option>
                        <option value="2019/2020">2019/2020</option>
                    </select>
                </div>
                <?php };?>
                <div class="col-md-2">
                    <select name="semester" id="" class="form-control">
                        <option value="semua" >semua semester</option>
                        <option value="Genap" >Genap</option>
                        <option value="Ganjil" >Ganjil</option>
                    </select>
                </div>
                <div class="col-md-2 ml-5">
                    <button type="submit" class="btn btn-success btn-block ">Filter Data</button>
                </div>
                <div class="col-md-2 ml-3">
                   <a href="<?=base_url('admin/info')?>" class="btn btn-danger btn-block">Hapus Filter</a>
                </div>
            </div>
        </div>
    </form>
</div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-body border-info">
                <h6>Grafik Nilai Guru</h6>
                <div class="row">
                    <div class="col-md-8">
                    <canvas id="dashGuru" width="100" height="100"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h5><b>Tahun Ajaran</b></h5>
                        2 Tahun Terakhir
                        <div class="mb-3"></div>
                        <h5><b>Kriteria</b></h5>
                        Baik : <br>
                        Kurang Baik : 
                    </div>
                </div>
                <a href="<?=base_url('admin/detailRecordPresensi')?>" class="btn btn-sm btn-info float-right mt-3">lihat detail</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-body border-info">
                <h6>Grafik Kegiatan Siswa</h6>
                <div class="row">
                    <div class="col-md-8">
                    <canvas id="dashSiswa" width="100" height="100"></canvas>
                    </div>
                    <div class="col-md-4">
                        <h5><b>Tahun Ajaran</b></h5>
                        2 Tahun Terakhir
                        <div class="mb-3"></div>
                        <h5><b>Kriteria</b></h5>
                        Baik : <br>
                        Kurang Baik : 
                    </div>
                </div>
                <a href="<?=base_url('admin/info_kegiatan')?>" class="btn btn-sm btn-info float-right mt-3">Lihat Detail</a>
            </div>
        </div>
    </div>
</div>

        <!-- <div class="col-md-12">
            <div class="card card-body border-info">
                <h6>Grafik Minat Kegiatan Siswa</h6>
                <div class="row">
                    <div class="col-md-12">
                    <canvas id="dashKetertarikan" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div> -->

<script>
var dash = document.getElementById('dashGuru').getContext('2d');
var dashGuru = new Chart(dash, {
	type: 'pie',
	data: {
		labels: ['Baik', 'Kurang Baik'],
		datasets: [{
			label: '# of Votes',
			data: [12, 19],
			backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)'
			],
			borderWidth: 2
		}]
	}
});
var dash1 = document.getElementById('dashSiswa').getContext('2d');
var dashSiswa = new Chart(dash1, {
	type: 'pie',
	data: {
		labels: ['Good Boy', 'Bad Boy'],
		datasets: [{
			label: '# of Votes',
			data: [12, 19],
			backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)'
			],
			borderWidth: 2
		}]
	}
});
// var dash1 = document.getElementById('dashKetertarikan').getContext('2d');
// var dashKetertarikan = new Chart(dash1, {
// 	type: 'horizontalBar',
// 	data: {
// 		labels: ['Basket', 'Futsal','Renang','Bulu Tangkis','Catur'],
// 		datasets: [{
// 			label: 'Basket',
// 			data: [12, 19, 10, 5, 11],
// 			backgroundColor: [
// 				'rgba(255, 99, 132, 0.2)',
// 				'rgba(54, 162, 235, 0.2)'
// 			],
// 			borderWidth: 2
// 		}],
// 	},
    
// });
</script>