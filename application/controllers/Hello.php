<?php 

class Hello extends CI_Controller {
  public function index(){
    // $this->load->('contoh_view');
    $this->load->model('M_mhs');
    $data['mahasiswa'] = $this->M_mhs->get_data();
    $this->load->view('v_mhs', $data);
  } 
}

?>