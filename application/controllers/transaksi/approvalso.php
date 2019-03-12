<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approvalso extends CI_Controller {
    public function __construct()
	{
		parent::__construct();
        $this->load->model('transaksi/M_approvalso','approvalso');  
        $this->load->model('transaksi/M_salesorder','salesorder');
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
        $data=array(         
			'all'  => $this->salesorder->ambilDataSalesOrder(),
        );
        
		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('transaksi/approvalso/index',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function get_data_approvalso()
    {
        $list = $this->approvalso->get_datatables_approvalso();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_So;
            $row[] = $field->Tgl_So;
            $row[] = $field->Nm_Cust;     
			$row[] = $field->Jns_Bayar;
            $row[] ='<button type="button" data-toggle="modal" data-target="#modal_approvalso'.$field->No_So.'" class="btn btn-primary">Approve</button>';		
			$data[] = $row;
					
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->approvalso->count_all(),
            "recordsFiltered" => $this->approvalso->count_filtered(),
            "data" => $data,
		);		
        echo json_encode($output);
    }
    
    function approve(){
        $this->db->trans_begin();
        
        /* Insert table piutang */
        $No_So=$this->input->post('txt_no_so');      
        $data_piutang = $this->approvalso->_insert_detail_piutang($No_So);


        foreach($data_piutang->result_array() AS $field) {         
            $data = array(
                'Kd_Cust'=>  $field['Kd_Cust'],
                'No_So'=>  $field['No_So'],
                'No_Ref'=>  $field['No_Ref'],
                'Tgl_So'=> $field['Tgl_So'],
                'Tgl_Jtp'=> $field['Tgl_Jtp'],
                'Nilai_Piutang'=> $field['Nilai_Piutang'],
                'Jumlah_Bayar'=>  $field['Jumlah_Bayar'],
                'Tgl_Bayar_Terakhir'=>  $field['Tgl_Bayar_Terakhir'],
                'Status_Piutang'=>  $field['Status_Piutang']           
            );
            $this->db->insert('tb_piutang', $data); 
        }
         /* End Insert table piutang */

        $hasil = $this->approvalso->prosesapprovalso();
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect(base_url('transaksi/approvalso'));
    }

}