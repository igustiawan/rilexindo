<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesorder extends MY_Controller {

    public function __construct()
	{
		parent::__construct();
		$this->load->model('transaksi/M_salesorder','salesorder');
		$this->load->model('transaksi/M_spk','spk');
		$this->load->model('master/M_salesman','salesman');
		$this->load->model('master/M_leasing','leasing');   
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
        $this->load->view('transaksi/salesorder/index',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

	function tambah()
	{   
		$data = array(
			'd_list_spk'  => $this->spk->get_list_spk(),
			'd_salesman' => $this->salesman->ambilDataSalesman(),
			'd_leasing' => $this->leasing->ambilDataLeasing()
		);
		     
		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('transaksi/salesorder/tambah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}
	
	function get_data_salesorder()
    {
        $list = $this->salesorder->get_datatables_salesorder();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_So;
            $row[] = $field->Tgl_So;
            $row[] = $field->Nm_Cust;     
			$row[] = $field->Jns_Bayar;
			if ($field->Status=="Waiting Process"){
                $row[]='<span class="label label-success">Waiting Process</span>';	
                $row[] = 
                '
                <a href="'.base_url().'transaksi/salesorder/ubah/'.$field->No_So.'" rel="tooltip" class="btn btn-warning btn-xs" title="Ubah"><i class="fa fa-pencil " ></i></a>
                <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_proses'.$field->No_So.'" title="Proses" rel="tooltip"><i class="fa fa-upload" ></i></a>
			   	<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal_batal'.$field->No_So.'" title="Batal" rel="tooltip"><i class="fa fa-trash"></i></a>
				'
				;					
			}elseif ($field->Status=="Process"){               
                $row[]='<span class="label label-info">Process</span>';	
                $row[]="";
			}elseif ($field->Status=="Waiting Approval"){   
				$row[]='<span class="label label-success">Waiting Approval</span>';	
				$row[]="";
			}elseif ($field->Status=="Approved" && $field->Cetak=="0" ){   
				$row[]='<span class="label label-info">Approved</span>';	
				$row[]=
				//'<a class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modal_print'.$field->No_So.'" title="Print" rel="tooltip"><i class="fa fa-print"></i></a>			
				//'<a href="'.base_url().'transaksi/salesorder/cetak/'.$field->No_So.'" target="_blank" class="btn btn-primary btn-xs" id="Cetaks" title="Print" rel="tooltip"><i class="fa fa-print"></i></a>'
				//'<a href="'.base_url('transaksi/salesorder/cetak/'.$field->No_So).'" id=CetakSo class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>'
				'<a id=CetakSo class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>'
				;				
			}elseif ($field->Status=="Approved" && $field->Cetak=="1" && $field->Status_Bast=="0" ){   
				$row[]='<span class="label label-info">Approved</span>';	
				$row[]=
				'<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#modal_persetujuan_bast'.$field->No_So.'" title="Persetujuan Bast" rel="tooltip"><i class="fa fa-mail-forward" ></i></a>		
				';				
			}elseif ($field->Status=="Approved" && $field->Status_Bast=="1" ){
				$row[]='<span class="label label-info">Approved</span>';	
                $row[]="";
			}elseif ($field->Status=="Batal"){             
				$row[]='<span class="label label-warning">Batal</span>';	
                $row[]="";
			}
			$data[] = $row;					
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->salesorder->count_all(),
            "recordsFiltered" => $this->salesorder->count_filtered(),
            "data" => $data,
		);
		
        echo json_encode($output);
	}
	
	function search(){
		$nospk = $this->input->post('nospk');
		$data = $this->salesorder->viewByNoSpk($nospk);
		
		if( ! empty($data)){
			// Buat sebuah array
			$callback = array(
				'status' => 'success',
				'Nm_Cust' => $data->Nm_Cust, 
				'Kd_Cust' => $data->Kd_Cust, 
				'Alamat' => $data->Alamat,
				'Jns_Bayar' => $data->Jns_Bayar,
				'No_Mesin' => $data->No_Mesin,
				'No_Chassis' => $data->No_Chassis,
				'Tipe' => $data->Tipe,	
				'Warna' => $data->Warna,
				'Jml_Harga' => number_format($data->Jml_Harga, '0', ',', '.'),	
				'Tipe_Angs' => $data->Tipe_Angs,
				'Angsuran' => number_format($data->Angsuran, '0', ',', '.'),
				// 'Angsuran' => $data->Angsuran,		
				'Tenor' => $data->Tenor,		
			);
		}else{
			$callback = array('status' => 'failed'); // set array status dengan failed
		}
		echo json_encode($callback); // konversi varibael $callback menjadi JSON
	}

	public function ubah($No_So = NULL)
	{  
		if($_POST)
        { 
			$txt_no_so       	    = $this->input->post('txt_no_so');
			$No_Spk       	        = $this->input->post('txt_nospk');
            $txt_bunga          	= $this->input->post('txt_bunga');
			$txt_tunai       		= $this->input->post('txt_tunai');
			$txt_hrg_mobil       	= $this->input->post('txt_hrg_mobil');
			$txt_dp_murni       	= $this->input->post('txt_dp_murni');
			$txt_adm      			= $this->input->post('txt_adm');
			$txt_angsuran_1      	= $this->input->post('txt_angsuran_1');
			$txt_lama_angs      	= $this->input->post('txt_lama_angs');
			$txt_jml_angs      		= $this->input->post('txt_jml_angs');
			$txt_biaya_adm      	= $this->input->post('txt_biaya_adm');
			$txt_keterangan      	= $this->input->post('txt_keterangan');
			$txt_nomesin      		= $this->input->post('txt_nomesin');
			$txt_diskon      		= $this->input->post('txt_diskon');

			$this->form_validation->set_rules('txt_diskon','Nominal Diskon','trim|required');   
			$this->form_validation->set_rules('txt_tunai','Nominal Tunai','trim|required');   
			$this->form_validation->set_rules('txt_dp_murni','Nominal DP','trim|required');  
			$this->form_validation->set_rules('txt_adm','Nominal ADM','trim|required');  
			$this->form_validation->set_rules('txt_bunga','Nominal Bunga','trim|required'); 
			$this->form_validation->set_rules('txt_lama_angs','Lama Angsuran','trim|required'); 
			$this->form_validation->set_rules('txt_jml_angs','Jumlah Angsuran','trim|required');

			$this->form_validation->set_message('required', '%s harus diisi');

			if ($this->form_validation->run() == TRUE) { 
                  
                $update_so = $this->salesorder->update_transaksi_so($txt_no_so,$txt_tunai,$txt_hrg_mobil,$txt_dp_murni,
							$txt_adm,$txt_angsuran_1,$txt_bunga,$txt_lama_angs,$txt_jml_angs,
							$txt_biaya_adm,$txt_keterangan,$txt_nomesin,$txt_diskon);

                if($update_so)
                {
                    echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil diubah !"));    
                }else
                {
                    $this->query_error();
                }
                       
            }else
            {             
                echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
			} 
			
		}else{
			$result = array();
            $so_data = $this->salesorder->getSoData($No_So);
            $result['tb_so'] = $so_data;            
            $this->data['so_data'] = $result;
            $this->render_template('transaksi/salesorder/ubah',$this->data);
		}
	}

	function simpan(){
        if($_POST)
        {
			$nospk        	   		= $this->input->post('nospk');
			$datepicker         	= $this->input->post('datepicker');
			$kd_salesman        	= $this->input->post('kd_salesman');
			$txt_jns_pembayaran 	= $this->input->post('txt_jns_pembayaran');
			$kd_leasing         	= $this->input->post('kd_leasing');
			$txt_po_leasing         = $this->input->post('txt_po_leasing');
			$txt_cust        		= $this->input->post('txt_cust');
			$txt_kd_cust        	= $this->input->post('txt_kd_cust');
			$txt_alamat       	    = $this->input->post('txt_alamat');
			$txt_tunai       	    = $this->input->post('txt_tunai');
			$txt_hrg_mobil       	= $this->input->post('txt_hrg_mobil');
			$txt_dp_murni       	= $this->input->post('txt_dp_murni');
			$txt_adm      		 	= $this->input->post('txt_adm');
			$txt_angsuran_1      	= $this->input->post('txt_angsuran_1');
			$txt_bunga      		= $this->input->post('txt_bunga');
			$txt_lama_angs      	= $this->input->post('txt_lama_angs');
			$txt_jml_angs     	 	= $this->input->post('txt_jml_angs');
			$txt_biaya_adm     	 	= $this->input->post('txt_biaya_adm');
			$txt_keterangan     	= $this->input->post('txt_keterangan');
			$txt_nomesin     		= $this->input->post('txt_nomesin');
			$txt_diskon     		= $this->input->post('txt_diskon');

			$callback			= '';
            if($txt_jns_pembayaran =="Kredit"){
                $callback = "trim|required";
            }

			$this->form_validation->set_rules('nospk','No Spk','trim|required');
			$this->form_validation->set_rules('txt_jns_pembayaran','Jenis Pembayaran','trim|required');
			$this->form_validation->set_rules('txt_cust','Customer','trim|required'	);
			$this->form_validation->set_rules('txt_alamat','Alamat','trim|required'	);
			$this->form_validation->set_rules('kd_salesman','Salesman','trim|required');

			$this->form_validation->set_rules('kd_leasing','Leasing',$callback);
			$this->form_validation->set_rules('txt_po_leasing','PO Leasing',$callback);

			$this->form_validation->set_message('required', '%s harus diisi');

            if($this->form_validation->run() == TRUE)
            {              
		
				$kd= $this->salesorder->idSalesOrder();

				$data_header = array(
					'No_So'=> $kd,
					'Tgl_So'=> $datepicker,
					'Kd_Cust'=> $txt_kd_cust, 
					'Nm_Cust'=> $txt_cust, 
					'Alamat'=> $txt_alamat, 
					'Kd_Salesman'=> $kd_salesman, 
					'Jns_Bayar'=>  $txt_jns_pembayaran, 
					'By_Tunai'=> preg_replace("/[^0-9]/", "", $txt_tunai), 
					'Ttl_Hrg_Otr'=> preg_replace("/[^0-9]/", "", $txt_hrg_mobil), 
					'DP'=> preg_replace("/[^0-9]/", "", $txt_dp_murni), 
					'ADM'=> preg_replace("/[^0-9]/", "", $txt_adm), 
					'ADDM'=> preg_replace("/[^0-9]/", "", $txt_angsuran_1), 
					'Bunga'=> preg_replace("/[^0-9]/", "", $txt_bunga), 
					'Tenor'=> $txt_lama_angs, 
					'Angsuran'=> preg_replace("/[^0-9]/", "", $txt_jml_angs),   
					'Tipe_Angs'=> $txt_biaya_adm, 
					'Keterangan'=> $txt_keterangan, 
					'Status'=> "Waiting Process",
					'Cetak'=> "0",
					'No_Spk'=> $nospk, 
					'No_Po_Leasing'=> $txt_po_leasing,
					'Kd_Fincoy'=> $kd_leasing, 
				);
				         
				$data_detail = array(
					'Fk_So'=> $kd,
					'No_Mesin' => $txt_nomesin,
					'Diskon' => preg_replace("/[^0-9]/", "", $txt_diskon), 
				);

				$salesorder = $this->salesorder->simpanHeaderDetailSalesOrder($data_header, $data_detail);
                if($salesorder)
                {
					echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));   
                }else
                {
                    $this->query_error();
                }              
            }else
            {             
               echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
			}
			
		}
	}
	
	function batal(){
        $hasil = $this->salesorder->batalsalesorder();
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect(base_url('transaksi/salesorder'));
	}
	
	function proses(){
        $hasil = $this->salesorder->prosesalesorder();
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect(base_url('transaksi/salesorder'));
	}
	
	function proses_persetujuan_bast(){
		$hasil = $this->salesorder->prosespersetujuanbast();
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect(base_url('transaksi/salesorder'));
	}

	public function cetak($no_so){
		$order_data = $this->salesorder->getOrdersData($no_so);

		$this->db->query("update tb_so set Cetak= '1' where No_So = '".$order_data['No_So']."'"); 

		$this->load->library('cfpdf');		
		$pdf = new FPDF('P','mm','letter');
		$pdf->AddPage();
		$pdf->SetFont('Arial','',10);	

		$pdf->Cell(110, 14, $order_data['No_So'], 0, 0, 'R');
		$pdf->Ln();

		$pdf->SetX(20);
		$pdf->Cell(110, 6, $order_data['Nm_Cust'], 0, 0, 'L'); 
		$pdf->Cell(85, 6,  $order_data['Pekerjaan'], 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetX(20);
		$pdf->Cell(80, 6,  $order_data['No_Polisi'], 0, 0, 'L');

		$pdf->Ln();

		$pdf->SetX(130);
		$pdf->Cell(20, 6,  $order_data['Alamat'], 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(130);
		$pdf->Cell(20, 6,  $order_data['Telepon'], 0, 0, 'L');	

		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();

		$pdf->SetX(20);
		$pdf->Cell(60, 6,  $order_data['Tipe'], 0, 0, 'L');	
		$pdf->Cell(30, 6,  1, 0, 0, 'L');	
		$pdf->Cell(50, 6,  'Rp.' . ' ' . number_format($order_data['Hrg_Jual']), 0, 0, 'L');	
		$pdf->Cell(30, 6,  'Rp.' . ' ' . number_format($order_data['Hrg_Jual']), 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(20);
		$pdf->Cell(55, 6,  $order_data['Warna'], 0, 0, 'L');
		$pdf->Cell(35, 6,  'Discount', 0, 0, 'L');	

		$pdf->Cell(30, 6,  'Rp.' . ' ' . number_format($order_data['Diskon']), 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(20);
		$pdf->Cell(57, 6,  $order_data['No_Chassis'], 0, 0, 'L');	
		$pdf->Cell(33, 6,  'Netto', 0, 0, 'L');	
		$pdf->Cell(30, 6,  'Rp.' . ' ' . number_format($order_data['Hrg_Jual']+$order_data['Diskon']), 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(20);
		$pdf->Cell(80, 6,  $order_data['No_Mesin'], 0, 0, 'L');	

		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();

		$pdf->Ln();
		$pdf->SetX(160);
		$pdf->Cell(30, 6,  'Rp.' . ' ' . number_format($order_data['Hrg_Jual']+$order_data['Diskon']), 0, 0, 'L');	

		$pdf->Ln();$pdf->Ln();$pdf->Ln();

		$pdf->SetX(25);
		$pdf->Cell(30, 6,  number_format($order_data['Hrg_Jual']+$order_data['Diskon']), 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(25);
		$pdf->Cell(30, 6,  number_format($order_data['Hrg_Jual']+$order_data['Diskon']), 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(25);
		$pdf->Cell(30, 6,  number_format($order_data['DP']), 0, 0, 'L');

		$pdf->Ln();
		$pdf->SetX(25);
		$pdf->Cell(30, 6,  number_format($order_data['ADM']), 0, 0, 'L');	

		$pdf->Ln();
		$pdf->SetX(25);
		$pdf->Cell(60, 6,  number_format($order_data['Angsuran']), 0, 0, 'L');	
		$pdf->Cell(30, 6,  number_format($order_data['Tenor']), 0, 0, 'L');

		$pdf->Output('I');
		exit;
	}
}