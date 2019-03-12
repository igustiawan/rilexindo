<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jasaservice extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('master/M_jasaservice','jasaservice'); //load model, simpan ke m
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

    function get_data_jasaservice()
    {
        $list = $this->jasaservice->get_datatables_jasaservice();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Service;
            $row[] = $field->Deskripsi;
            $row[] = number_this($field->Harga);
			if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/jasaservice/ubah/'.$field->Kd_Service.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jasaservice->count_all(),
            "recordsFiltered" => $this->jasaservice->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
    function index()
	{
        $data = array(
			'd_jasaservice' => $this->jasaservice->ambilDataJasaService()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/jasaservice/index', $data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/jasaservice/tambah');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function simpan(){
		$hasil = $this->jasaservice->simpanDataJasaService();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/jasaservice'));
    }

    function ubah($id)
	{
        $data = array(
            'd_jasaservice' => $this->jasaservice->ambilDataJasaServicebyID($id)
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/jasaservice/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function update(){
		$hasil = $this->jasaservice->updateDataJasaService();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/jasaservice'));
      }
      
}