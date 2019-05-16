<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spk extends MY_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('transaksi/M_spk','spk');
        $this->load->model('master/M_salesman','salesman');
        $this->load->model('master/M_leasing','leasing');   
        $this->load->model('master/M_stock_kendaraan','stockkendaraan');  
        $this->load->model('master/M_list_customer','listcustomer');           
        $this->load->library('form_validation');   
        $this->load->library('session'); 
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }

    function get_data_spk()
    {
        $list = $this->spk->get_datatables_spk();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Spk;
            $row[] = $field->Nm_Cust;
            $row[] = $field->Alamat;
            $row[] = $field->No_Mesin;
            $row[] = $field->Tipe;
            $row[] = $field->Warna;
            if ($field->Jns_Bayar=="T"){
				$row[]='<span>Tunai</span>';		
			}else{
				$row[]='<span>Kredit</span>';	
            }
            if ($field->Status=="Waiting Process"){
                $row[]='<span class="label label-success">Waiting Process</span>';	
                $row[] = 
                '
                <a href="'.base_url().'transaksi/spk/ubah/'.$field->No_Spk.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i></a>
                <a class="btn btn-info btn-xs" href="'.base_url().'transaksi/spk/proses/'.$field->No_Spk.'" id="ProsesSpk"><i class="fa fa-upload" ></i></a>
                <a class="btn btn-danger btn-xs" href="'.base_url().'transaksi/spk/batal/'.$field->No_Spk.'" id="BatalSpk"><i class="fa fa-trash" ></i></a>
                '
               ;	
			}elseif ($field->Status=="Process"){                
                $row[]='<span class="label label-info">Process</span>';	
                $row[]="";
            }else
            {
                $row[]='<span class="label label-warning">Batal</span>';	
                $row[]="";
            }
            $data[] = $row;
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->spk->count_all(),
            "recordsFiltered" => $this->spk->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get_data_stock()
    {
        $list = $this->stockkendaraan->get_datatables_stock();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Mesin;
            $row[] = $field->No_Chassis;
            $row[] = $field->kd_tipe;
            $row[] = $field->Tipe;
            $row[] = $field->kd_merek;
            $row[] = $field->Merek;
            $row[] = $field->Kd_Warna;
            $row[] = $field->Warna;
            $row[] = $field->Hrg_Jual;
            $data[] = $row;
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stockkendaraan->count_all(),
            "recordsFiltered" => $this->stockkendaraan->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function get_data_list_cust()
    {
        $list = $this->listcustomer->get_datatables_list_cust();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->Kd_Cust;
            $row[] = $field->Nm_Cust;
            $row[] = $field->JnsKel;
            $row[] = $field->Alamat1;
            $data[] = $row;
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->listcustomer->count_all(),
            "recordsFiltered" => $this->listcustomer->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    function index()
	{
        $data=array(         
            "all"=>$this->db->get('tb_spk')->result()
        );
        
     	$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('transaksi/spk/index',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function tambah()
	{
        $data = array(
            'd_salesman' => $this->salesman->ambilDataSalesman(),
            'd_leasing' => $this->leasing->ambilDataLeasing(),
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('transaksi/spk/tambah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    }

    public function ubah($No_Spk = NULL)
	{    
        if($_POST)
        {   
            $No_Spk       	        = $this->input->post('txt_no_spk');
            $optJnsKel       	    = $this->input->post('optJnsKel');
            $datepicker         	= $this->input->post('datepicker');
            $txt_alamat       	    = $this->input->post('txt_alamat');
            $kd_salesman            = $this->input->post('kd_salesman');
            $txt_nomesin        	= $this->input->post('txt_nomesin');
            $txt_kd_merek       	= $this->input->post('txt_kd_merek');
            $txt_kd_tipe       	    = $this->input->post('txt_kd_tipe');
            $txt_kd_warna       	= $this->input->post('txt_kd_warna');
            $txt_harga_kendaraan    = $this->input->post('txt_harga_kendaraan');
            $kd_leasing         	= $this->input->post('kd_leasing');
            $txt_uang_muka       	= $this->input->post('txt_uang_muka');
            $txt_jns_road       	= $this->input->post('txt_jns_road');
            $txt_jns_angsuran       = $this->input->post('txt_jns_angsuran');
            $txt_kd_warna       	= $this->input->post('txt_kd_warna');
            $txt_jns_pembayaran 	= $this->input->post('txt_jns_pembayaran');
            $txt_tenor          	= $this->input->post('txt_tenor');
            $txt_bunga          	= $this->input->post('txt_bunga');
            $txt_angsuran       	= $this->input->post('txt_angsuran');
            
            $callback			= '';
            if($txt_jns_pembayaran =="Kredit"){
                $callback = "trim|required";
            }

            $this->form_validation->set_rules('txt_alamat','Alamat','trim|required');             
            $this->form_validation->set_rules('txt_harga_kendaraan','Harga Kendaraan','trim|required');
            $this->form_validation->set_rules('txt_uang_muka','Uang Muka','trim|required');   
            
            $this->form_validation->set_rules('kd_leasing','Leasing',$callback);
            $this->form_validation->set_rules('txt_tenor','Tenor',$callback);
            $this->form_validation->set_rules('txt_bunga','Bunga',$callback);
            $this->form_validation->set_rules('txt_angsuran','Angsuran',$callback);

            $this->form_validation->set_message('required', '%s harus diisi');
            
            if ($this->form_validation->run() == TRUE) { 
                  
                $this->db->trans_begin();
                $update_spk = $this->spk->update_transaksi_spk($No_Spk,$datepicker, $txt_alamat, 
                            $kd_salesman, $txt_jns_pembayaran, $txt_kd_merek,$txt_kd_tipe, 
                            $txt_kd_warna, $txt_harga_kendaraan, $txt_uang_muka,$txt_angsuran, 
                            $kd_leasing,$txt_tenor,$txt_bunga,$txt_jns_angsuran,$txt_jns_road,
                            $optJnsKel);

                if($update_spk)
                {
                    $this->db->trans_commit();
                    echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil diubah !"));    
                }else
                {
                    $this->db->trans_rollback();
                    $this->query_error();
                }
                       
            }else
            {             
                echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
            } 
        }else {            	
            $result = array();
            $spk_data = $this->spk->getSpkData($No_Spk);
            $result['tb_spk'] = $spk_data;     
    
            $this->data['tb_customer'] = $this->leasing->getActiveLeasing();         
            $this->data['tb_salesman'] = $this->salesman->getActiveSalesman();         
            $this->data['spk_data'] = $result;
            $this->render_template('transaksi/spk/ubah',$this->data);
        }
    }

    function simpan(){
        if($_POST)
        {
            $txt_cust        	    = $this->input->post('txt_cust');
            $txt_kd_cust        	= $this->input->post('txt_kd_cust');
            $optJnsKel       	    = $this->input->post('optJnsKel');
            $datepicker         	= $this->input->post('datepicker');
            $txt_alamat       	    = $this->input->post('txt_alamat');
            $kd_salesman            = $this->input->post('kd_salesman');
            $txt_nomesin        	= $this->input->post('txt_nomesin');
            $txt_kd_merek       	= $this->input->post('txt_kd_merek');
            $txt_kd_tipe       	    = $this->input->post('txt_kd_tipe');
            $txt_kd_warna       	= $this->input->post('txt_kd_warna');
            $txt_harga_kendaraan    = $this->input->post('txt_harga_kendaraan');
            $kd_leasing         	= $this->input->post('kd_leasing');
            $txt_uang_muka       	= $this->input->post('txt_uang_muka');
            $txt_jns_road       	= $this->input->post('txt_jns_road');
            $txt_jns_angsuran       = $this->input->post('txt_jns_angsuran');
            $txt_kd_warna       	= $this->input->post('txt_kd_warna');
            $txt_jns_pembayaran 	= $this->input->post('txt_jns_pembayaran');
            $txt_tenor          	= $this->input->post('txt_tenor');
            $txt_bunga          	= $this->input->post('txt_bunga');
            $txt_angsuran       	= $this->input->post('txt_angsuran');
            $Status             	= "Waiting Process";
            $Cetak              	= 0;
   
            $callback			= '';
            if($txt_jns_pembayaran =="Kredit"){
                $callback = "trim|required";
            }

            $this->form_validation->set_rules('txt_kd_cust','Customer','trim|required');
            $this->form_validation->set_rules('optJnsKel','Jenis Kelamin','trim|required');
            $this->form_validation->set_rules('txt_alamat','Alamat','trim|required');
            $this->form_validation->set_rules('kd_salesman','Salesman','trim|required');
            $this->form_validation->set_rules('txt_nomesin','No Mesin','trim|required');
            $this->form_validation->set_rules('txt_harga_kendaraan','Harga Kendaraan','trim|required');
            $this->form_validation->set_rules('txt_uang_muka','Uang Muka','trim|required');   
            
            $this->form_validation->set_rules('kd_leasing','Leasing',$callback);
            $this->form_validation->set_rules('txt_tenor','Tenor',$callback);
            $this->form_validation->set_rules('txt_bunga','Bunga',$callback);
            $this->form_validation->set_rules('txt_angsuran','Angsuran',$callback);

            $this->form_validation->set_message('required', '%s harus diisi');

            if($this->form_validation->run() == TRUE)
            {              
                $this->db->trans_begin();
                $spk = $this->spk->insert_transaksi_spk($datepicker, $txt_kd_cust, $txt_cust, $txt_alamat, 
                            $kd_salesman, $txt_jns_pembayaran, $txt_kd_merek, 
                            $txt_kd_tipe, $txt_kd_warna, $txt_harga_kendaraan, $txt_uang_muka, 
                            $txt_angsuran, $kd_leasing,$txt_tenor,$txt_bunga,$txt_jns_angsuran,$Status,$Cetak,
                            $txt_jns_road,$optJnsKel,$txt_nomesin);

                if($spk)
                {
                    $this->db->trans_commit();
                    echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));    
                }else
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

    public function proses($No_Spk)
	{
        if($this->input->is_ajax_request())
        {
            $this->db->trans_begin();
            $no_mesin = $this->input->post('no_mesin');
 
            $prosesspk = $this->spk->proses_spk($No_Spk);
            if($prosesspk)
            {
                $update_stok_spk = $this->spk->update_stok_spk($no_mesin,$No_Spk);    

                if($update_stok_spk)
                {
                    $this->db->trans_commit();
                    echo json_encode(array(
                        "pesan" => "Data berhasil diproses
                    "));
                }             
            }
            else
            {
                $this->db->trans_rollback();
                $this->query_error();
                echo json_encode(array(
                    "pesan" => "Terjadi kesalahan, coba lagi !
                "));
            }
        }
    }

    public function batal($No_Spk)
	{
        if($this->input->is_ajax_request())
        {
            $this->db->trans_begin();

            $batal_spk = $this->spk->batal_spk($No_Spk);
            if($batal_spk)
            {             
                $this->db->trans_commit();
                echo json_encode(array(
                    "pesan" => "Data berhasil dibatalkan
                "));                         
            }
            else
            {
                $this->db->trans_rollback();
                $this->query_error();
                echo json_encode(array(
                    "pesan" => "Terjadi kesalahan, coba lagi !
                "));
            }
        }
    }
}