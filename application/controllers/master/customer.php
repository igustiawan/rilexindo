<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('master/M_customer','customer'); //load model, simpan ke m
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

    function get_data_customer()
    {
        $list = $this->customer->get_datatables_customer();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Cust;
            $row[] = $field->Nm_Cust;
            $row[] = $field->Alamat1;
            $row[] = $field->Kelurahan;
            $row[] = $field->Kecamatan;
            $row[] = $field->KTP;
            if ($field->JnsKel=="L"){
				$row[]='Laki-Laki';		
			}else{
				$row[]='Perempuan';	
			}
            if ($field->Status=="A"){
				$row[]='<span class="label label-danger">Aktif</span>';		
			}else{
				$row[]='<span class="label label-warning">Tidak Aktif</span>';	
			}
			$row[] = '<a href="'.base_url().'master/customer/ubah/'.$field->Kd_Cust.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customer->count_all(),
            "recordsFiltered" => $this->customer->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
    function index()
	{
        $data = array(
			'd_customer' => $this->customer->ambilDataCustomer()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/customer/index', $data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }   

    function tambah()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/customer/tambah');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function simpan(){
		$hasil = $this->customer->simpanDataCustomer();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('master/customer'));
    }


    function ubah($id)
	{
        $data = array(
            'd_customer' => $this->customer->ambilDataCustomerbyID($id)
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('master/customer/ubah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function update(){
		$hasil = $this->customer->updateDataCustomer();
		if($hasil){
		  $this->session->set_flashdata('psn_sukses','Data telah diubah');
		}
		else {
		  $this->session->set_flashdata('psn_error','Gagal mengubah data ');
		}
		redirect(base_url('master/customer'));
	  }


}