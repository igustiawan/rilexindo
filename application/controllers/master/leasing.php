<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leasing extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('master/M_leasing','leasing'); //load model, simpan ke m
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

    function get_data_leasing()
    {
        $list = $this->leasing->get_datatables_leasing();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Cust;
            $row[] = $field->Nm_Cust;
            $row[] = $field->Alamat1;
            if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/leasing/ubah/'.$field->Kd_Cust.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->leasing->count_all(),
            "recordsFiltered" => $this->leasing->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
    function index()
	{
        $data = array(
			'd_leasing' => $this->leasing->ambilDataLeasing()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/leasing/index', $data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/leasing/tambah');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function simpan(){
		$hasil = $this->leasing->simpanDataLeasing();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/leasing'));
    }

    function ubah($id)
	{
        $data = array(
            'd_leasing' => $this->leasing->ambilDataLeasingbyID($id)
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/leasing/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function update(){
		$hasil = $this->leasing->updateDataLeasing();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/leasing'));
      }
      
}