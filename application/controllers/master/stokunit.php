<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stokunit extends MY_Controller {

    public function __construct()
	{
		parent::__construct();  
		$this->load->model('master/M_stokunit','stokunit'); 
		$this->_cek_login();
	}

	function _cek_login()
	{
		if (!isset($this->session->userdata['id_user'])) {
	    redirect(base_url("login"));
	  }
    }
	
	function get_data_stokunit()
    {
        $list = $this->stokunit->get_datatables_stokunit();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Mesin;
			$row[] = $field->No_Chassis;
			$row[] = $field->Warna;
			$row[] = $field->Kapasitas;
			$row[] = $field->Thn_Produksi;
			$row[] = $field->No_Polisi;
			$row[] = $field->Status;
			$row[] = '<a href="'.base_url().'master/stokunit/ubahharga/'.$field->No_Mesin.'" id="UbahHarga" class="btn btn-warning btn-xs" ><i>Ubah Harga</i>';
            $data[] = $row;
        }
 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stokunit->count_all(),
            "recordsFiltered" => $this->stokunit->count_filtered(),
            "data" => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
	}

    function index()
	{
 
     	$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('master/stokunit/index');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

	function ubahharga($No_Mesin)
	{
		if( ! empty($No_Mesin))
		{ 
			if($this->input->is_ajax_request())
			{

				if($_POST)
				{
					//update data
					$this->load->library('form_validation');

					$this->form_validation->set_rules('hrg_jual','Harga Jual','trim|required|alpha_numeric');

					$this->form_validation->set_message('required','%s harus diisi !');
					$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

					if($this->form_validation->run() == TRUE)
						{
							$hrg_jual 	= $this->input->post('hrg_jual');

							$update = $this->stokunit->update_harga_jual($No_Mesin, $hrg_jual);
							if($update)
							{
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
								));
							}
							else
							{
								$this->query_error();
							}
						}
						else
						{
							$this->input_error();
						}
				}else
				{
					$dt['detail'] = $this->stokunit->get_detail($No_Mesin)->row();
					$this->load->view('master/stokunit/ubah_harga',$dt);
				}
			}
		}
	}

}