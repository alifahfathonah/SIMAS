<?php

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('kelas_model');
        $this->load->model('mapel_model');
        $this->load->model('siswa_model');
        $this->load->model('guru_model');
        $this->load->model('login_model');
        $this->load->model('pengaturan_model');
        $this->load->model('mutu_model');
        $this->load->model('presensi_model');
        $this->load->model('dasbord_model');
        $this->load->helper('text');
        if($this->login_model->is_role()== ""){
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses');
            redirect('');
        }
    }

    

    public function informasi()
    {
        $data['page']='informasi';
        $data['informasi']=$this->pengaturan_model->getInformasi();
        $this->load->view('templates/header',$data);
        $this->load->view('informasi/informasi',$data);
        $this->load->view('templates/footer');
    }

    public function detailInformasi($id)
    {
        $data['page']='informasi';
        $data['informasi']=$this->pengaturan_model->getInformasiID($id);
        $this->load->view('templates/header',$data);
        $this->load->view('informasi/detail',$data);
        $this->load->view('templates/footer');
    }

    public function tbhInformasi()
    {
        $data['page']='informasi';
        $this->load->view('templates/header',$data);
        $this->load->view('informasi/add');
        $this->load->view('templates/footer');
    }

    public function addInformasi()
    {
        $insert = $this->pengaturan_model->addInformasi();
        if($insert > 0)
        {
            $this->session->set_flashdata('success', 'Informasi ditambahkan');
        }else{
            $this->session->set_flashdata('error', 'Informasi gagal ditambahkan');
        }

        redirect('admin/informasi');
    }

    public function deleteInformasi($id)
    {
        $delete = $this->pengaturan_model->deleteInformasi($id);
        if($delete > 0)
        {
            $this->session->set_flashdata('success', 'Informasi dihapus');
        }else{
            $this->session->set_flashdata('error', 'Informasi gagal dihapus');
        }

        redirect('admin/informasi');
    }



    public function index()
    {
        $data['page']='dashboard';
        $data['laporanmutu']=$this->mutu_model->getMutu();
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/index',$data);
        $this->load->view('templates/footer');
    }

    public function info()
    {
        $data['page']='dashboard';
        $data['tahun_akademik']=$this->mutu_model->gettahunAkademik();

        if(!isset($_GET['key1']) && !isset($_GET['key2']))
        {
            $data['nilai_kegiatan']=$this->mutu_model->getnilaiKegiatan();
        }

        if(isset($_GET['key1']) && !isset($_GET['key2']))
        {
            $dari = $_GET['dari'];
            $semester = $_GET['semester'];

            if($dari=='semua' && $semester=='semua'){

                $data['nilai_kegiatan']=$this->mutu_model->getnilaiKegiatan();

            }else if($dari!='semua' && $semester=='semua'){

                $data['nilai_kegiatan']=$this->mutu_model->getmodel1NonSemester($dari);
                
            }else if($dari =='semua' && $semester !='semua'){
                
                $data['nilai_kegiatan']=$this->mutu_model->getmodel1Semester($semester);

            }else if($dari !='semua' && $semester !='semua'){

                $data['nilai_kegiatan']=$this->mutu_model->getmodel1Semua($dari,$semester);

            }
        }

        if(isset($_GET['key1']) && isset($_GET['key2']))
        {
            $dari = $_GET['dari'];
            $sampai = $_GET['sampai'];
            $semester = $_GET['semester'];

            if($dari=='semua' && $sampai=='semua' && $semester=='semua'){

                $data['nilai_kegiatan']=$this->mutu_model->getnilaiKegiatan();

            }else if($dari!='semua' && $sampai=='semua' && $semester=='semua'){

                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen0($dari);
                
            }else if($dari!='semua' && $sampai!='semua' && $semester=='semua'){
                
                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen1($dari,$sampai);
                
            }else if($dari!='semua' && $sampai!='semua' && $semester!='semua'){
                
                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen2($dari,$sampai,$semester);
                
            }else if($dari=='semua' && $sampai!='semua' && $semester!='semua'){
                
                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen3($sampai,$semester);

            }else if($dari=='semua' && $sampai=='semua' && $semester!='semua'){

                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen4($semester);
                
            }else if($dari!='semua' && $sampai=='semua' && $semester!='semua'){
                
                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen5($dari,$semester);
                
            }else if($dari=='semua' && $sampai!='semua' && $semester=='semua'){
                
                $data['nilai_kegiatan']=$this->mutu_model->getnilaiBeetwen6($sampai);
            }
        }

        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/infoMutu',$data);
        $this->load->view('templates/footer');
    }

    public function detailRecordPresensi()
    {
        $data['page']='dashboard';
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/detail');
        $this->load->view('templates/footer');
    }

    public function trackRecord()
    {
        $data['page']="trackrecord";
        //$data['peserta']=$this->kelas_model->daftarPeserta($id);
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/trackRecord',$data);
        $this->load->view('templates/footer');
    }

    public function laporan_waka()
    {
        $data['page']='dashboard';
        $tahun_akademik= $_GET['key1'];
        $semester= $_GET['semester'];
        $data['nama_kegiatan']=$this->dasbord_model->getdasbordKeuangan();
        $data['rataKeuangan']=$this->dasbord_model->getdasbordRataKeuanganfilter($tahun_akademik,$semester);
        $data['infoKegiatan']=$this->dasbord_model->getInfokegiatan($tahun_akademik,$semester);
        $data['kegiatan']=$this->dasbord_model->getKegiatan($tahun_akademik,$semester);
        $data['jumlah']=$this->dasbord_model->getjumlahPeserta($tahun_akademik,$semester);
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/kegiatan_laporan',$data);
        $this->load->view('templates/footer');
    }
    
    public function info_kegiatan()
    {
        if(!isset($_GET['key1']) && !isset($_GET['key2']))
        {
           $data['info_keuangan']=$this->dasbord_model->getdefault_anggaran();
        }

        if(isset($_GET['key1']) && !isset($_GET['key2']))
        {
            $dari = $_GET['key1'];
            $semester = $_GET['semester'];

            if($dari=='semua' && $semester=='semua'){

                $data['info_keuangan']=$this->dasbord_model->getdefault_anggaran();
                //echo deffault;

            }else if($dari!='semua' && $semester=='semua'){

                $data['info_keuangan']=$this->dasbord_model->getanggaran_th1($dari);
                //echo 'tahun dipilih,semester semua';
                
            }else if($dari =='semua' && $semester !='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_semester($semester);
                //echo 'tahun semua, semester dipilih';

            }else if($dari !='semua' && $semester !='semua'){

                $data['info_keuangan']=$this->dasbord_model->getanggaran_th1_semester($dari,$semester);
                //echo 'tahun dipilih, semester dipilih';

            }
        }

        if(isset($_GET['key1']) && isset($_GET['key2']))
        {
            $dari = $_GET['key1'];
            $sampai = $_GET['key2'];
            $semester = $_GET['semester'];

            if($dari=='semua' && $sampai=='semua' && $semester=='semua'){

                $data['info_keuangan']=$this->dasbord_model->getdefault_anggaran();
                // echo 'default';
                
            }else if($dari!='semua' && $sampai=='semua' && $semester=='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_between1($dari);
                //    echo 'th1 dipilih, th2 semua, semester semua';
                
            }else if($dari!='semua' && $sampai!='semua' && $semester=='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_between2($dari,$sampai);
                // echo 'th1 dipilih, th2 dipilih, semester semua';
                
            }else if($dari!='semua' && $sampai!='semua' && $semester!='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_between3($semester,$dari,$sampai);
                // echo ' th1 dipilih, th2 dipilih, semester dipilih';

            }else if($dari=='semua' && $sampai!='semua' && $semester!='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_between4($semester,$sampai);
                // echo 'th1 semua, th2 dipilih, semester dipilih';

            }else if($dari=='semua' && $sampai=='semua' && $semester!='semua'){

                $data['info_keuangan']=$this->dasbord_model->getanggaran_between5($semester);
                // echo 'th1 semua, th2 semua, semester dipilih';

            }else if($dari!='semua' && $sampai=='semua' && $semester!='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_between6($dari,$semester);
                //    echo 'th1 dipilih, th2 semua, semester dipilih';
                
            }else if($dari=='semua' && $sampai!='semua' && $semester=='semua'){
                
                $data['info_keuangan']=$this->dasbord_model->getanggaran_between7($sampai);
                // echo 'th1 semua, th2 dipilih, semester semua';
            }
        }
        $data['page']='dashboard';
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/info_Kegiatan',$data);
        $this->load->view('templates/footer');
     }
    public function info_Detailkegiatan()
    {
        // $data['page']='dashboard';
        $data['info_keuangan']=$this->dasbord_model->getdasbordRataKeuangan();
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/detail_kegiatanTahun',$data);
        $this->load->view('templates/footer');
    }

    // Star Ricky
    // Nyimpan Dokumen
    public function addDocMutu($id,$code)
    {
        $backLink= $backid;
        $code_id = $code.'_'.$id;

        $config['upload_path']          = './document/';
		$config['allowed_types']        = '*';
		$config['max_size']             = 5000;
		$config['encrypt_name'] 		= true;
		$this->load->library('upload',$config);
		$judul = $this->input->post('judul');
        $jumlah_berkas = count($_FILES['arsip']['name']);
        
		for($i = 0; $i < $jumlah_berkas;$i++)
		{
            if(!empty($_FILES['arsip']['name'][$i])){
 
				$_FILES['file']['name'] = $_FILES['arsip']['name'][$i];
				$_FILES['file']['type'] = $_FILES['arsip']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['arsip']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['arsip']['error'][$i];
				$_FILES['file']['size'] = $_FILES['arsip']['size'][$i];
	   
				if($this->upload->do_upload('file')){
					
					$uploadData = $this->upload->data();
					$data['code_id'] = $code_id;
					$data['nama_doc'] = $judul[$i];
					$data['link_file'] = $uploadData['file_name'];
					$data['type_file'] = $uploadData['file_ext'];
                    $this->db->insert('trans_doc',$data);
                    $this->session->set_flashdata('success', 'Dokumen berhasil ditambahkan');
				}else{
                    $this->session->set_flashdata('error', 'Dokumen gagal ditambah');
                }
			}
        }
        
        redirect('admin/mutu');
    }

    // Lampiran Mutu
    

    public function do_addMutu()
    {
        $id= $this->mutu_model->addMutu();
        //echo $id;
        $code='mutu';
        $this->addDocMutu($id,$code);
    }

    public function downloadMutu($id)
    {
        //ngambil link
        $code_id='mutu_'.$id;
        $link= $this->mutu_model->getLink($code_id);

        foreach($link as $lk)
        {
            $this->do_download($lk['link_file']);
        }
        //ngirim link download
    }

    public function do_download($file)
    {
        $this->load->helper('download');
        force_download(FCPATH.'/document/'.$file, null);
    }

    public function mutu()
    {
        $data['page']='mutu';
        // $data['id']= $id;
        $data['laporanmutu']=$this->mutu_model->getMutu();
        $this->load->view('templates/header',$data);
        $this->load->view('mutu/rekap_laporan');
        $this->load->view('templates/footer');
    }

    public function detailMutu($id)
    {
        $data['page']='detail';
        $data['id']= $id;
        $data['laporanmutu']=$this->mutu_model->getMutu();
        $data['detailmutu']=$this->mutu_model->getLaporanMutuID($id);
        //$data['arsipmutu']=$this->mutu_model->getLink($code_id);
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/detail_mutu',$data);
        $this->load->view('templates/footer');
    }

    public function tambahMutu()
    {
        $data['page']='mutu';
        $this->load->view('templates/header',$data);
        $this->load->view('mutu/tambah_mutu');
        $this->load->view('templates/footer');
    }

    public function deleteMutu($id)
    {
        // echo $id;
        $delete=$this->mutu_model->deleteMutuID($id);
        if($delete > 0){
            $this->session->set_flashdata('success', 'Mutu Dihapus'); 
        }else{
            $this->session->set_flashdata('error', 'Mutu Gagal Dihapus'); 
        }

        redirect('admin/mutu');
    }

    public function rekapLaporanMutu()
    {
        $data['page']='mutu';
        // $data['id']= $id;
        // $data['laporanmutu']=$this->mutu_model->getLaporanMutuID($id);
        $this->load->view('templates/header',$data);
        $this->load->view('mutu/tambah_mutu');
        $this->load->view('templates/footer');
    }

    public function addMutunilai()
    {
        $insert=$this->mutu_model->addMutu();
        $tahun_akademik = $this->input->post('tahun_akademik',TRUE);
        //$data['mutunilai']=$this->mutu_model->getMutu();
        if($insert > 0)
        {
            $this->session->set_flashdata('success', 'Mutu berhasil disimpan');
        }else
        {
            $this->session->set_flashdata('success', 'Mutu gagal disimpan');
        }
        redirect('admin/mutu');
    }

    public function updateMutu()
    {
        
        $tahun_akademik = $_POST['th_akademik1'].'/'. $_POST['th_akademik2'];
        // $data['laporanmutu']=$this->mutu_model->getMutu();
        $update=$this->mutu_model->editMutu($tahun_akademik);
        if($update > 0)
        {
            $this->session->set_flashdata('success', 'Mutu berhasil diubah');
        }else
        {
            $this->session->set_flashdata('success', 'Mutu gagal diubah');
        }
        redirect('admin/mutu');
    }

    public function exportDasbordKegiatan()
    { 
        //membuat objek
        $objPHPExcel = new PHPExcel();
        $data = $this->db->query("
            SELECT siswa.*, concat(kelas.kelas,' ', kelas.jurusan,' ',kelas.sub) as kelas
            FROM siswa
            LEFT JOIN peserta_kelas ON peserta_kelas.id_siswa=siswa.id_siswa
            LEFT JOIN kelas ON peserta_kelas.id_kelas = kelas.id_kelas
            GROUP BY siswa.id_siswa");
         // Nama Field Baris Pertama
        $fields = $data->list_fields();
        
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }
 
        // Mengambil Data
        $row = 2;
        foreach($data->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
 
            $row++;
        }
        $objPHPExcel->setActiveSheetIndex(0);

        //Set Title
        $objPHPExcel->getActiveSheet()->setTitle('Data Kegiatan Siswa');



        $objPHPExcel->setActiveSheetIndex(0);

       
        //Save ke .xlsx, kalau ingin .xls, ubah 'Excel2007' menjadi 'Excel5'
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        //Header
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        //Nama File
        // header('Content-Disposition: attachment;filename="Survei_Guru"'.$id.'".xlsx"');
        header('Content-Disposition: attachment;filename="Data_dasbordKegiatan.xlsx"');

        //Download
        $objWriter->save("php://output");
    }

    // Ricky

    // siswa
    public function siswa()
    {
        $data['page']='tambahSiswa';
        $data['kelas']=$this->kelas_model->get();
        $this->load->view('templates/header',$data);
        $this->load->view('siswa/tambahSiswa',$data);
        $this->load->view('templates/footer');
    }

    public function detailRecordKegiatan()
    {
        $data['page']='dashboard';
        $this->load->view('templates/header',$data);
        $this->load->view('dashboard/detail');
        $this->load->view('templates/footer');
    }

    public function addSiswa()
    {
        $cek = $this->siswa_model->add();
        if($cek==false)
        {
            $this->session->set_flashdata('error', 'NIPD Sudah Terdaftar');
        }else
        {
            $this->session->set_flashdata('success', 'Siswa Berhasil Ditambahkan');
        }
        redirect('admin/siswa');
    }

    public function daftarSiswa()
    {
        $data['page']='daftarSiswa';
        $data['daftar']=$this->siswa_model->daftarSiswa();
        $data['kelas']=$this->kelas_model->get();
        $this->load->view('templates/header',$data);
        $this->load->view('siswa/daftarSiswa',$data);
        $this->load->view('templates/footer');
    }

    public function hapusSiswa()
    {
        
    }
    // end of siswa

    // kelas
    public function kelas()
    {
        $data['page']='kelas';
        $data['jumlah_peserta']=$this->kelas_model->getJumlahPeserta();
        $this->load->view('templates/header',$data);
        $this->load->view('kelas/kelas',$data);
        $this->load->view('templates/footer');
    }

    public function addKelas()
    {
        $kelas = $this->input->post('kelas', true);
        $jurusan = $this->input->post('jurusan', true);
        if($kelas=='0'||$jurusan=='0'){
            $this->session->set_flashdata('error', 'Kesalahan Input Kelas / Jurusan');
        }
        else{
            $this->kelas_model->Add();
            $this->session->set_flashdata('success', 'Data Ditambahkan');
        }
        redirect('admin/kelas'); 
    }

    public function deleteKelas($id)
    {
        $this->kelas_model->deleteKelas($id);
        $this->session->set_flashdata('error', 'Kelas dihapus');
        redirect('admin/kelas');
    }

    public function daftarPeserta($id)
    {
        $data['page']="kelas";
        $data['id']= $id;
        $data['peserta']=$this->kelas_model->daftarPeserta($id);
        $data['kelas']=$this->kelas_model->get();
        $this->load->view('templates/header',$data);
        $this->load->view('kelas/daftarPeserta',$data);
        $this->load->view('templates/footer');
    }

    public function addPeserta()
    {
        $id_siswa = $_POST['id_siswa'];
        $id_kelas = $_POST['id_kelas']; 
        $insert= $this->kelas_model->addPeserta($id_siswa, $id_kelas);
        $this->session->set_flashdata('success', 'Data Peserta Kelas Ditambahkan');
        redirect('admin/daftarPeserta/'.$id_kelas);
    }

    public function hapusPeserta($id, $backid)
    {
        $hapus = $this->kelas_model->hapusPeserta($id);
        if($hapus >0){
            $this->session->set_flashdata('success', 'Data Peserta Kelas Dihapus');
        }else{
            $this->session->set_flashdata('error', 'Data Peserta Kelas Gagal Dihapus');
        }
        redirect('admin/daftarPeserta/'.$backid);
    }

    public function pindahPeserta()
    {
        $backid= $_POST['backid'];

        $pindah = $this->kelas_model->pindahPeserta();
        if($pindah >0){
            $this->session->set_flashdata('success', 'Data Peserta Kelas Berhasil Dipindah');
        }else{
            $this->session->set_flashdata('error', 'Data Peserta Kelas Gagal Dipindah');
        }
        redirect('admin/daftarPeserta/'.$backid);
    }
    // end of kelas

    // Mata pelajaran
    public function mapel()
    {
        $data['page']="mapel";
        $data['mapel']=$this->mapel_model->getMapel();
        $this->load->view('templates/header',$data);
        $this->load->view('mapel/index',$data);
        $this->load->view('templates/footer');
    }

    public function tambahMapel()
    {
        $this->mapel_model->Add();
        $this->session->set_flashdata('success', 'Data Ditambahkan');
        redirect('admin/mapel'); 
    }

    public function editMapel()
    {   
        $id=$this->input->post('id_mapel',true);
        $nama=$this->input->post('nama_mapel',true);
        $deskripsi=$this->input->post('deksripsi_mapel',true);
        $this->mapel_model->Update($id,$nama,$deskripsi);
        $this->session->set_flashdata('success', 'Data Berhasil Diubah');
        redirect('admin/mapel'); 
    }

    public function deleteMapel($id)
    {
        $this->mapel_model->Delete($id);
        $this->session->set_flashdata('error', 'Data Berhasil Dihapus');
        redirect('admin/mapel'); 
    }

    // End of mata pelajaran

    // guru
    public function guru()
    {
        $data['page']='addGuru';
        $this->load->view('templates/header',$data);
        $this->load->view('guru/addGuru');
        $this->load->view('templates/footer');
    }

    public function deleteGuru($id)
    {
        $this->guru_model->deleteGuru($id);
        $this->session->set_flashdata('error', 'Data Guru dihapus');
        redirect('admin/daftarGuru');
    }

    public function addGuru()
    {
        $cek = $this->guru_model->add();
        if($cek!=true)
        {
            $this->session->set_flashdata('error', 'RFID / NIP Sudah Terdaftar');
        }else
        {
            $this->session->set_flashdata('success', 'Guru Berhasil Ditambahkan');
        }
        redirect('admin/guru');
    }

    public function editGuru()
    {
        $id_guru = $_POST['id'];
        $nip = $_POST['nip'];
        $niplama = $_POST['niplama'];
        $rfid = $_POST['rfid'];
        $nama = $_POST['nama'];
        $alamat = $_POST['alamat'];
        $password = $_POST['pass'];
        $status = $_POST['status'];

        $editGuru=$this->guru_model->editGuru($id_guru,$nip, $rfid, $nama, $alamat, $password, $status);

        $updateUser=$this->guru_model->updateUser($niplama, $nip, $password, $nama);

        if($editGuru > 0 || $updateUser > 0 )
        {
            $this->session->set_flashdata('success', 'Data Guru Berhasil Diubah');
        }else
        {
            $this->session->set_flashdata('error', 'Data Guru Gagal Diubah');
        }
        redirect('admin/daftarGuru');
    }

    public function daftarGuru()
    {
        $data['page']='daftarGuru';
        $data['guru']=$this->guru_model->get();
        $data['jadwal']=$this->guru_model->getJadwalAll();
        $this->load->view('templates/header',$data);
        $this->load->view('guru/daftarGuru',$data);
        $this->load->view('templates/footer');
    }

    public function jadwalMengajar($id)
    {
        $data['page']='daftarGuru';
        $data['guru']=$this->guru_model->getId($id);
        $data['jadwal']=$this->guru_model->getJadwal($id);
        $data['kelas']=$this->kelas_model->get();
        $data['mapel']=$this->mapel_model->getMapel();
        $data['tahun_akademik']=$this->pengaturan_model->getAkademik();
        $data['id_guru']= $id;
        $this->load->view('templates/header',$data);
        $this->load->view('guru/jadwalMengajar',$data);
        $this->load->view('templates/footer');
    }

    public function addJadwal()
    {
        $tahun_akademik = $this->input->post('tahun_akademik',TRUE);
        $semester = $this->input->post('semester',TRUE);

        // echo $tahun_akademik;
        // echo $semester;
        $guru = $this->input->post('guru',TRUE);
        $hari = $this->input->post('hari',TRUE);
		$kelas = $this->input->post('kelas',TRUE);
		$mapel = $this->input->post('mapel',TRUE);
		$mulai = $this->input->post('mulai',TRUE);
        $selesai = $this->input->post('selesai',TRUE);
        if($guru=='0'||$hari=='0'||$kelas=='0'||$mulai=='0'||$selesai=='0'||$mapel=='0')
        {
            $this->session->set_flashdata('error', '<b>Kesalahan Input</b><br>Pastikan Seluruh Data Terisi');
        }
        else{
            $cek = $this->guru_model->addJadwal($tahun_akademik, $semester, $guru, $hari, $kelas, $mulai, $selesai);
            $this->session->set_flashdata('success', 'Jadwal Guru Berhasil Disimpan');
        }
        redirect('admin/jadwalMengajar/'.$guru.'');
    }

    public function validasiJadwal()
    {
        $setAkademik=$this->pengaturan_model->getAkademik();

        foreach($setAkademik as $set){
            echo json_encode($this->guru_model->validasiJadwal($set['tahun_akademik'], $set['semester']));
        }

        // echo json_encode($_POST['id_guru']);

    }

    public function deleteJadwal($id,$backid)
    {
        $delete = $this->guru_model->deleteJadwal($id);
        if($delete > 0)
        {
            $this->session->set_flashdata('success', 'Jadwal dihapus');
        }else{
            $this->session->set_flashdata('error', 'Jadwal gagal dihapus');
        }

        redirect('admin/jadwalMengajar/'.$backid);
    }
    // end of guru

    // verifikasi ijin guru
    public function ijinGuru()
    {
        $data['page']='ijin';
        $data['ijin']=$this->guru_model->getIjin();
        $data['statIjin']=$this->guru_model->getStatusIjin();
        $this->load->view('templates/header',$data);
        $this->load->view('guru/verifikasiIjin',$data);
        $this->load->view('templates/footer');
    }

    public function addStatIjin()
    {
        $id = $_POST['id_ijin'];
        $stat = $_POST['status'];
        $catatan = $_POST['catatan'];
        $update=$this->guru_model->addStatus($id,$stat,$catatan);
        if($update > 0){
            $this->session->set_flashdata('success', 'Status Berhasil Diubah');
        }else{
            $this->session->set_flashdata('danger', 'Status Gagal Diubah');
        }
        redirect('admin/ijinGuru');
    }
    // end of verifikasi ijin guru

    // presensi
    public function daftarPresensi()
    {
        $data['page']='presensi';
        $data['guru']=$this->guru_model->get();
        $this->load->view('templates/header',$data);
        $this->load->view('guru/daftarPresensi',$data);
        $this->load->view('templates/footer');
    }

    public function detailPresensi($id)
    {
        $data['page']='presensi';
        $data['id'] = $id;
        //$data['jamhadir']=$this->presensi_model->getJamhadirGuru($id);
        if(isset($_GET['dari']))
        {
            $data['jamhadir']=$this->presensi_model->getJamhadirGuru($id);
        }else
        {
            $data['jamhadir']=$this->presensi_model->getDefaultJamHadir($id);
        }
        if(isset($_GET['dari']))
        {
            $data['jamkerja']=$this->presensi_model->getJamkerjaGuru($id);
        }else
        {
            $data['jamkerja']=$this->presensi_model->getDefaultJamKerja($id);
        }
        $this->load->view('templates/header',$data);
        $this->load->view('guru/detailPresensi',$data);
        $this->load->view('templates/footer');
    }

    public function rekapKehadiran($id)
    {
        $data['page']='presensi';
        $data['id'] = $id;
        $this->load->view('templates/header',$data);
        $this->load->view('guru/rekapKehadiran',$data);
        $this->load->view('templates/footer');
    }
    // end of presensi

    // pengguna
    public function pengguna()
    {
        $data['page']='pengguna';
        $data['user']=$this->pengaturan_model->getPengguna();
        $this->load->view('templates/header',$data);
        $this->load->view('pengaturan/pengguna',$data);
        $this->load->view('templates/footer');
    }

    public function addPengguna()
    {
        $res=$this->pengaturan_model->addPengguna();
        if($res==false)
        {
            $this->session->set_flashdata('error', 'Username telah terdaftar');
        }else
        {
            $this->session->set_flashdata('success', 'User Berhasil Ditambahkan');
        }
        redirect('admin/pengguna');
    }

    public function deletePengguna($id)
    {
        $this->pengaturan_model->deletePengguna($id);
        $this->session->set_flashdata('success', 'User Berhasil dihapus');
        redirect('admin/pengguna');
    }

    public function editPengguna()
    {
        $res=$this->pengaturan_model->editPengguna();
        if($res==false)
        {
            $this->session->set_flashdata('error', 'Username telah terdaftar');
        }else
        {
            $this->session->set_flashdata('success', 'Data diubah');
        }
        redirect('admin/pengguna');
    }
    // end of pengguna


    // tanggal libur
    public function libur()
    {
        $data['page']='libur';
        $data['libur']=$this->pengaturan_model->getTanggalLibur();
        $this->load->view('templates/header',$data);
        $this->load->view('pengaturan/libur',$data);
        $this->load->view('templates/footer');
    }

    public function addLibur()
    {
        $insert=$this->pengaturan_model->addLibur();
        if($insert > 0)
        {
            $this->session->set_flashdata('success', 'Tanggal Libur berhasil disimpan');
        }else
        {
            $this->session->set_flashdata('success', 'Tanggal Libur gagal disimpan');
        }
        redirect('admin/libur');
    }

    public function deleteLibur($id)
    {
        $delete=$this->pengaturan_model->deleteLibur($id);
        if($delete > 0)
        {
            $this->session->set_flashdata('success', 'Tanggal Libur berhasil dihapus');
        }else
        {
            $this->session->set_flashdata('success', 'Tanggal Libur gagal dihapus');
        }
        redirect('admin/libur');
    }

    public function updateLibur()
    {
        $update=$this->pengaturan_model->updateLibur();
        if($update > 0)
        {
            $this->session->set_flashdata('success', 'Tanggal Libur berhasil diubah');
        }else
        {
            $this->session->set_flashdata('success', 'Tanggal Libur gagal diubah');
        }
        redirect('admin/libur');
    }
    // end of tanggal libur

    //tahun akademik
    public function akademik()
    {
        $data['page']='akademik';
        $data['akademik']=$this->pengaturan_model->getAkademik();
        $this->load->view('templates/header',$data);
        $this->load->view('pengaturan/akademik',$data);
        $this->load->view('templates/footer');
    }

    public function updateAkademik()
    {
        $tahun_akademik = $_POST['tahun'].' / '. $_POST['tahun2'];

        $update=$this->pengaturan_model->updateAkademik($tahun_akademik);
        if($update > 0)
        {
            $this->session->set_flashdata('success', 'Tahun Akademik berhasil diubah');
        }else
        {
            $this->session->set_flashdata('success', 'Tahun Akademik gagal diubah');
        }
        redirect('admin/akademik');
    }
    // end of tahun akademik

    // Kegiatan EL
    // OSIS
    public function osis()
    {
        $data['page']='tambahOsis';
        $data['kelas']=$this->kelas_model->get();
        $this->load->view('templates/header',$data);
        $this->load->view('kegiatan/tambahOsis',$data);
        $this->load->view('templates/footer');
    }

    public function addOsis()
    {
        $cek = $this->siswa_model->add();
        if($cek==false)
        {
            $this->session->set_flashdata('error', 'NIPD Sudah Terdaftar');
        }else
        {
            $this->session->set_flashdata('success', 'Siswa Berhasil Ditambahkan');
        }
        redirect('admin/osis');
    }

    public function daftarOsis()
    {
        $data['page']='daftarOsis';
        $data['daftar']=$this->siswa_model->daftarSiswa();
        $data['kelas']=$this->kelas_model->get();
        $this->load->view('templates/header',$data);
        $this->load->view('kegiatan/daftarOsis',$data);
        $this->load->view('templates/footer');
    }

    // public function hapusSiswa()
    // {
        
    // }
    // End Of OSIS

    // End Of kegiatan El

    // Lampiran Mutu

    

}
