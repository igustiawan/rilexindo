<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('transaksi/M_pembelian','pembelian'); 
        $this->load->model('master/m_chain_kendaraan','chainkendaraan');
        $this->load->model('master/M_warna','warna');
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

    function get_tipe(){
        $id=$this->input->post('id');
        $data=$this->chainkendaraan->get_tipe($id);
        echo json_encode($data);
    }

    function get_data_pembelian()
    {
        $list = $this->pembelian->get_datatables_pembelian();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Transaksi;
            $row[] = $field->Tgl_Beli;
            $row[] = $field->Nm_Penjual;
            $row[] = $field->Tipe;
            $row[] = $field->Warna;
            $row[] = $field->No_Mesin;
            $row[] = $field->Thn_Produksi;
            $row[] = $field->No_Polisi;
			//$row[] = '<a href="'.base_url().'transaksi/pembelian/ubah/'.$field->Kd_Merek.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i>';
            $data[] = $row;
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pembelian->count_all(),
            "recordsFiltered" => $this->pembelian->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
    }
    
    function index()
	{

        $data = array(
            'd_pembelian' => $this->pembelian->ambilDataPembelian()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('transaksi/pembelian/index', $data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function tambah()
	{
        $data = array(
            'd_tipe'  => $this->chainkendaraan->get_merek(),
            'd_warna'  => $this->warna->ambilDataWarnaStatus()
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('transaksi/pembelian/tambah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    function simpan(){
		$hasil = $this->pembelian->simpanDataPembelian();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('transaksi/pembelian'));
    }

}