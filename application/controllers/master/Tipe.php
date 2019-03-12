<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipe extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('master/M_tipe','tipe');
		$this->load->model('master/M_merek','merek');
		$this->_cek_login();
    }
    
    function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

    function index()
	{
        $data = array(
			'd_tipe' => $this->tipe->ambilDataTipe()
		 );

		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/tipe/index', $data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }   
	
	function get_data_tipe()
    {
        $list = $this->tipe->get_datatables_tipe();
        $data = array();
		$no = $_POST['start'];
		
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Tipe;
			$row[] = $field->Tipe;
			$row[] = $field->Merek;
			if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/tipe/ubah/'.$field->Kd_Tipe.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->tipe->count_all(),
            "recordsFiltered" => $this->tipe->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

	function tambah()
	{
		$data = array(
			'd_merek' => $this->merek->ambilDataMerekStatus()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/tipe/tambah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}
	
	function simpan(){
		$hasil = $this->tipe->simpanDataTipe();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/tipe'));
	}
	
	function ubah($id)
	{
        $data = array(
			'd_tipe' => $this->tipe->ambilDataTipebyID($id),
			'd_merek' => $this->merek->ambilDataMerekStatus()
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/tipe/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}
	
	function update(){
		$hasil = $this->tipe->updateDataTipe();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/tipe'));
	  }

}