<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merek extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->load->model('master/M_merek','mp'); //load model, simpan ke m
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

	function get_data_merek()
    {
        $list = $this->mp->get_datatables_merek();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Merek;
			$row[] = $field->Merek;
			if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/merek/ubah/'.$field->Kd_Merek.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->mp->count_all(),
            "recordsFiltered" => $this->mp->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

    function index()
	{
        $data = array(
			'd_merek' => $this->mp->ambilDataMerek()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/merek/index', $data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }   

    function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/merek/tambah');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function simpan(){
		$hasil = $this->mp->simpanDataMerek();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/merek'));
    }
    
    function ubah($id)
	{
        $data = array(
            'd_merek' => $this->mp->ambilDataMerekbyID($id)
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/merek/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }
	
	function update(){
		$hasil = $this->mp->updateDataMerek();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/merek'));
	  }

}