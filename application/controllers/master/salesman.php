<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesman extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('master/M_salesman','salesman'); //load model, simpan ke m
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

	function get_data_salesman()
    {
        $list = $this->salesman->get_datatables_salesman();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Salesman;
			$row[] = $field->Nm_Salesman;
			$row[] = $field->Alamat1;
			$row[] = $field->Telepon;
			if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/salesman/ubah/'.$field->Kd_Salesman.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->salesman->count_all(),
            "recordsFiltered" => $this->salesman->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

    function index()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/salesman/index');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }  

	function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/salesman/tambah');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}
	
	function simpan(){
		$hasil = $this->salesman->simpanDataSalesman();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/salesman'));
    }
	
	
	function ubah($id)
	{
		$data = array(
            'd_salesman' => $this->salesman->ambilDataSalesmanbyID($id)
        );
				
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/salesman/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}

	function update(){
		$hasil = $this->salesman->updateDataSalesman();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/salesman'));
	  }

}