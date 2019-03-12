<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Spk extends CI_Controller {

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
                <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_proses'.$field->No_Spk.'" title="Proses" rel="tooltip"><i class="fa fa-upload" ></i></a>
                <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal_batal'.$field->No_Spk.'" title="Batal" rel="tooltip"><i class="fa fa-trash" ></i></a>
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

    function simpan(){
    
        $config = array(
            array(
                'field' => 'txt_alamat',
                'label' => 'Alamat Lengkap',
                'rules' => 'required|xss_clean',
                'errors' => array(
                    'required' => 'Alamat harus diisi..',
                            )
                ),
            array(
                'field' => 'txt_cust',
                'label' => 'Nama Customer',
                'rules' => 'required|xss_clean',
                'errors' => array(
                    'required' => 'Nama Customer harus diisi..',
                             )
                ),   
             array(
                    'field' => 'kd_salesman',
                    'label' => 'Salesman',
                    'rules' => 'required|xss_clean',
                    'errors' => array(
                        'required' => 'Nama Salesman harus diisi..',
                                 )
                    ),
             array(
                    'field' => 'txt_nomesin',
                    'label' => 'No. Mesin',
                    'rules' => 'required|xss_clean',
                    'errors' => array(
                        'required' => 'Nomor Mesin harus diisi..',
                                    )
                    )
                    
        );
           
      
        $this->form_validation->set_rules($config);
   
        if ($this->form_validation->run()==FALSE){
            $this->document->generate_page('transaksi/spk/tambah');         
        }
        else {  
            
            
            $hasil = $this->spk->simpanDataSpk();
            if($hasil){
                $this->session->set_flashdata('psn_sukses','Data telah disimpan');
            }
            else {
                $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
            }
            redirect(base_url('transaksi/spk'));
        }		
    }

    function proses(){
        $hasil = $this->spk->prosesDataSpk();
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect(base_url('transaksi/spk'));
    }

    function batal(){
        $hasil = $this->spk->batalspk();
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect(base_url('transaksi/spk'));
    }

}