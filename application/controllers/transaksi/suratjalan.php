<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suratjalan extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('transaksi/M_suratjalan','suratjalan');
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
        
     	$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('transaksi/suratjalan/index');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function get_data_suratjalan()
    {
        $list = $this->suratjalan->get_datatables_suratjalan();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Sj;
            $row[] = $field->Tgl_Sj;
            $row[] = $field->No_So;
            $row[] = $field->Nm_Cust; 
            $row[]=
				'<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_print'.$field->No_Sj.'" title="Print" rel="tooltip"><i class="fa fa-print"></i></a>			
				';
            $data[] = $row;
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->suratjalan->count_all(),
            "recordsFiltered" => $this->suratjalan->count_filtered(),
            "data" => $data,
		);		
        echo json_encode($output);
    }
    
    function tambah()
	{     
        $data = array(
			'd_list_so'  => $this->suratjalan->get_list_so()
		);
        
     	$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('transaksi/suratjalan/tambah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function search(){
		$noso = $this->input->post('noso');
		$data = $this->suratjalan->viewByNoSo($noso);
		
		if( ! empty($data)){
			// Buat sebuah array
			$callback = array(
				'status' => 'success',
                'Nm_Cust' => $data->Nm_Cust, 
                'No_So' => $data->No_So, 
                'Tgl_So' => $data->Tgl_So,
				'Kd_Cust' => $data->Kd_Cust, 
				'Alamat' => $data->Alamat,
				'No_Mesin' => $data->No_Mesin,
				'No_Chassis' => $data->No_Chassis,
				'Tipe' => $data->Tipe,	
				'Warna' => $data->Warna		
			);
		}else{
			$callback = array('status' => 'failed'); // set array status dengan failed
		}
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
    }
    
    function simpan(){
		$hasil = $this->suratjalan->simpanDataSuratJalan();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('transaksi/suratjalan'));
    }
    
}