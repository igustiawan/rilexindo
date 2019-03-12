<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Warna extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('master/M_warna','warna'); //load model, simpan ke m
		$this->_cek_login();
    }
    
    function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

	function get_data_warna()
    {
        $list = $this->warna->get_datatables_warna();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Warna;
			$row[] = $field->Warna;
			if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/warna/ubah/'.$field->Kd_Warna.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->warna->count_all(),
            "recordsFiltered" => $this->warna->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function index()
	{
        $data = array(
			'd_warna' => $this->warna->ambilDataWarna()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/warna/index', $data);		
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}  
	
	function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/warna/tambah');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}
	
	function simpan(){
		$hasil = $this->warna->simpanDataWarna();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/warna'));
	}
	
	function ubah($id)
	{
        $data = array(
            'd_warna' => $this->warna->ambilDataWarnabyID($id)
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/warna/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}
	
	function update(){
		$hasil = $this->warna->updateDataWarna();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/warna'));
	  }
	  
}