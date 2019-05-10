<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembelian extends MY_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('transaksi/M_pembelian','pembelian'); 
        $this->load->model('master/m_chain_kendaraan','chainkendaraan');
        $this->load->model('master/M_warna','warna');
        $this->load->library('form_validation');
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
            $data[] = $row;
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pembelian->count_all(),
            "recordsFiltered" => $this->pembelian->count_filtered(),
            "data" => $data,
        );
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

        if($_POST)
        {
            $this->form_validation->set_rules('txt_nm_penjual','Customer','trim|required');
            $this->form_validation->set_rules('optJnsKel','Jenis Kelamin','trim|required');
            $this->form_validation->set_rules('txt_alamat','Alamat','trim|required');
            $this->form_validation->set_rules('kd_tipe','Kode Tipe','trim|required');
            $this->form_validation->set_rules('kd_merek','Kode Merek','trim|required');
            $this->form_validation->set_rules('kd_warna','Kode Warna','trim|required');
            $this->form_validation->set_rules('txt_no_polisi','No Polisi','trim|required');
            $this->form_validation->set_rules('txt_no_bpkb','No Bpkb','trim|required');
            $this->form_validation->set_rules('txt_nm_stnk','Nama Stnk','trim|required');
            $this->form_validation->set_rules('txt_no_rangka','No Rangka','trim|required');
            $this->form_validation->set_rules('txt_no_mesin','No Mesin','trim|required|callback_cek_nosin[txt_no_mesin]');
            $this->form_validation->set_rules('txt_no_stnk','No Stnk','trim|required');
            $this->form_validation->set_rules('txt_kapasitas','Kapasitas','trim|required');
            $this->form_validation->set_rules('txt_thn_produksi','Tahun Produksi','trim|required');
            $this->form_validation->set_rules('txt_tgl_beli','Tanggal Beli','trim|required');
            $this->form_validation->set_rules('txt_tgl_stnk','Tanggal Stnk','trim|required');
            
            $this->form_validation->set_message('required', '%s harus diisi');
            $this->form_validation->set_message('cek_nosin', '%s sudah ada');

            if($this->form_validation->run() == TRUE)
            {
                $txt_nm_penjual 	= $this->input->post('txt_nm_penjual');
                $optJnsKel 	        = $this->input->post('optJnsKel');
                $txt_alamat        	= $this->input->post('txt_alamat');
                $kd_tipe 	        = $this->input->post('kd_tipe');
                $kd_merek       	= $this->input->post('kd_merek');
                $kd_warna       	= $this->input->post('kd_warna');
                $txt_no_polisi 	    = $this->input->post('txt_no_polisi');
                $txt_no_bpkb 	    = $this->input->post('txt_no_bpkb');
                $txt_no_stnk 	    = $this->input->post('txt_no_stnk');
                $txt_nm_stnk 	    = $this->input->post('txt_nm_stnk');
                $txt_no_rangka  	= $this->input->post('txt_no_rangka');
                $txt_no_mesin 	    = $this->input->post('txt_no_mesin');
                $txt_kapasitas 	    = $this->input->post('txt_kapasitas');
                $txt_thn_produksi 	= $this->input->post('txt_thn_produksi');
                $txt_ongkir      	= $this->input->post('txt_ongkir');
                $txt_tgl_beli      	= $this->input->post('txt_tgl_beli');
                $txt_tgl_stnk      	= $this->input->post('txt_tgl_stnk');
                
                $this->db->trans_begin();
                $pembelian = $this->pembelian->insert_transaksi_pembelian($txt_nm_penjual, $optJnsKel, $txt_alamat, $kd_tipe, 
                                    $kd_merek, $kd_warna, $txt_no_polisi, $txt_no_bpkb, $txt_nm_stnk, 
                                    $txt_no_rangka, $txt_no_mesin, $txt_kapasitas, $txt_thn_produksi, 
                                    $txt_ongkir,$txt_tgl_beli,$txt_tgl_stnk,$txt_no_stnk);

                if($pembelian)
                {                       
                    $stok	= $this->pembelian->insert_stok($txt_no_mesin, $txt_no_rangka, $kd_tipe, $kd_warna, 
                                    $kd_merek, $txt_kapasitas, $txt_thn_produksi, $txt_no_polisi, 
                                    $txt_tgl_beli, $txt_ongkir, $txt_no_stnk,$txt_no_bpkb, 
                                    $txt_nm_stnk, $txt_tgl_stnk);
                    if($stok)
                    {
                        $this->db->trans_commit();
                        echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));       
                    }                                                                   
                }
                else
                {
                    $this->db->trans_rollback();
                    $this->query_error();
                }
            }else
            {
                echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
            }    
        }
    }

	public function cek_nosin($nomesin)
	{
		$cek = $this->pembelian->cek_nosin_validasi($nomesin);
		if($cek->num_rows() > 0)
		{
			return FALSE;
		}
		return TRUE;
	}
}