<?php 

class Mahasiswa extends CI_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form', 'url', 'file'));
  }

  public function index()
  {
    $this->load->model('M_mahasiswa');
    $data['mahasiswa'] = $this->M_mahasiswa->tampil_data()->result_array();
    $this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('mahasiswa', $data);
		$this->load->view('templates/footer');
  }

  public function tambah()
  {
    $this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('mahasiswa');
		$this->load->view('templates/footer');
  }

  public function tambah_aksi()
  {
    $nama = $this->input->post('nama');
    $nim = $this->input->post('nim');
    $tgl_lahir = $this->input->post('tgl_lahir');
    $jurusan = $this->input->post('jurusan');
    $alamat = $this->input->post('alamat');
    $email = $this->input->post('email');
    $no_telp = $this->input->post('no_telp');
    $foto = $_FILES['foto'];
    if ($foto = ''){}else{
      $config['upload_path'] = './assets/foto';
      $config['allowed_types'] = 'jpg|png|gif';
      $config['max_size']             = 100;
      $config['max_width']            = 1024;
      $config['max_height']           = 768;

      $this->load->library('upload', $config);
      // $this->upload->initialize($config);

      // $uploadData = $this->upload->data();
      // print_r($uploadData); die;
      // $image1=site_url().'upload/'.$uploadData['file_name'];
      // $data = array('foto' => $image1);

      if (!$this->upload->do_upload('foto')){
        echo $this->upload->display_errors(); die();
      } else {
        $foto = $this->upload->data('file_name');
      }

      // if (!$this->upload->do_upload('foto')){
      //   $error = array('error' => $this->upload->display_errors());

      //   $this->load->view('mahasiswa', $error);
      // } else {
      //   // $data = array('upload_data' => $this->upload->data());

      //   // $this->load->view('upload_success', $data);
      //   $foto = $this->upload->data('file_name');
      // }
    }

    $data = array(
      'nama' => $nama,
      'nim'  => $nim,
      'tgl_lahir' => $tgl_lahir,
      'jurusan' => $jurusan,
      'alamat' => $alamat,
      'email' => $email,
      'no_telp' => $no_telp,
      'foto' => $foto
    );

    $this->M_mahasiswa->input_data($data, 'tb_mahasiswa');
    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Data Berhasil Ditambahkan! </div>');
    redirect('mahasiswa/index');
  }

  public function hapus($id)
  {
    $where = array ('id' => $id);
    $this->M_mahasiswa->hapus_data($where, 'tb_mahasiswa');
    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Data Berhasil Dihapus! </div>');
    redirect('mahasiswa/index');
  }

  public function edit($id)
  {
    $where = array('id' => $id);
    $data['mahasiswa']= $this->M_mahasiswa->edit_data($where, 'tb_mahasiswa')->result_array();

    $this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('edit', $data);
		$this->load->view('templates/footer');
  }

  public function update()
  {
    $id = $this->input->post('id');
    $nama = $this->input->post('nama');
    $nim = $this->input->post('nim');
    $tgl_lahir = $this->input->post('tgl_lahir');
    $jurusan = $this->input->post('jurusan');
    $alamat = $this->input->post('alamat');
    $email = $this->input->post('email');
    $no_telp = $this->input->post('no_telp');

    $data = array(
      'nama' => $nama,
      'nim'  => $nim,
      'tgl_lahir' => $tgl_lahir,
      'jurusan' => $jurusan,
      'alamat' => $alamat,
      'email' => $email,
      'no_telp' => $no_telp,
      'foto' => $foto
    );

    $where= array(
      'id' => $id
    );

    $this->M_mahasiswa->update_data($where, $data, 'tb_mahasiswa');
    $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> Data Berhasil Diupdate! </div>');
    redirect('mahasiswa/index');
  }

  public function detail($id)
  {
    $this->load->model('M_mahasiswa');
    $detail = $this->M_mahasiswa->detail_data($id);
    $data['detail'] = $detail;

    $this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('detail', $data);
		$this->load->view('templates/footer');
  }

  public function print()
  {
    $data['mahasiswa'] = $this->M_mahasiswa->tampil_data('tb_mahasiswa')->result_array();
    $this->load->view('print_mahasiswa', $data);
  }

  public function pdf()
  {
    $this->load->library('dompdf_gen');
    $data['mahasiswa'] = $this->M_mahasiswa->tampil_data('tb_mahasiswa')->result_array();
    $this->load->view('laporan_pdf', $data);

    $paper_size = 'A4';
    $orientation = 'landscape';
    $html = $this->output->get_output();
    $this->dompdf->set_paper($paper_size, $orientation);
    $this->dompdf->load_html($html);
    $this->dompdf->render();
    $this->dompdf->stream("laporan_mahasiswa.pdf", array('Attachment' => 0));
  }

  public function excel()
  {
    $data['mahasiswa'] = $this->M_mahasiswa->tampil_data('tb_mahasiswa')->result_array();

    require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel.php');
    require(APPPATH. 'PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php');

    $object = new PHPExcel();

    $object->getProperties()->setCreator("Kipli Website");
    $object->getProperties()->setLastModifiedBy("Kipli Website");
    $object->getProperties()->setTitle("Daftar Mahasiswa");

    $object->setActiveSheetIndex(0);

    $object->getActiveSheet()->setCellValue('A1', 'NO');
    $object->getActiveSheet()->setCellValue('B1', 'NAMA MAHASISWA');
    $object->getActiveSheet()->setCellValue('C1', 'NIM');
    $object->getActiveSheet()->setCellValue('D1', 'TANGGAL LAHIR');
    $object->getActiveSheet()->setCellValue('E1', 'JURUSAN');
    $object->getActiveSheet()->setCellValue('F1', 'ALAMAT');
    $object->getActiveSheet()->setCellValue('G1', 'EMAIL');
    $object->getActiveSheet()->setCellValue('H1', 'NO. TELEPON');

    $baris = 2;
    $no = 1;

    foreach ($data['mahasiswa'] as $mhs) {
      // $object->getActiveSheet()->setCellValue('A'. $baris, $no++);
      // $object->getActiveSheet()->setCellValue('B'. $baris, $mhs->nama);
      // $object->getActiveSheet()->setCellValue('C'. $baris, $mhs->nim);
      // $object->getActiveSheet()->setCellValue('D'. $baris, $mhs->tgl_lahir);
      // $object->getActiveSheet()->setCellValue('E'. $baris, $mhs->jurusan);
      // $object->getActiveSheet()->setCellValue('F'. $baris, $mhs->alamat);
      // $object->getActiveSheet()->setCellValue('G'. $baris, $mhs->email);
      // $object->getActiveSheet()->setCellValue('H'. $baris, $mhs->no_telp);

      $object->getActiveSheet()->setCellValue('A'. $baris, $no++);
      $object->getActiveSheet()->setCellValue('B'. $baris, $mhs['nama']);
      $object->getActiveSheet()->setCellValue('C'. $baris, $mhs['nim']);
      $object->getActiveSheet()->setCellValue('D'. $baris, $mhs['tgl_lahir']);
      $object->getActiveSheet()->setCellValue('E'. $baris, $mhs['jurusan']);
      $object->getActiveSheet()->setCellValue('F'. $baris, $mhs['alamat']);
      $object->getActiveSheet()->setCellValue('G'. $baris, $mhs['email']);
      $object->getActiveSheet()->setCellValue('H'. $baris, $mhs['no_telp']);

      $baris++;
    }

    $filename = "Data_Mahasiswa".'.xlsx';
    $object->getActiveSheet()->setTitle("Data Mahasiswa");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Dispotition: attachment;filename="'. $filename. '"');
    header('Chace-Control:max-age=0');

    $writer = PHPExcel_IOFactory::createWriter($object, 'Excel2007');
    $writer->save('php://output');

    exit;
  }

  public function search()
  {
    $keyword = $this->input->post('keyword');
    $data['mahasiswa'] = $this->M_mahasiswa->get_keyword($keyword);

    $this->load->view('templates/header');
		$this->load->view('templates/sidebar');
		$this->load->view('mahasiswa', $data);
		$this->load->view('templates/footer');
  }
}

?>