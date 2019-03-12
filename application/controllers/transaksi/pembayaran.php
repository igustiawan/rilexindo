<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran extends MY_Controller {

    public function __construct()
	{		
		parent::__construct();
		$this->load->model('transaksi/M_pembayaran','pembayaran');
		$this->load->library('form_validation');	
	}

	function index()
	{
		$this->load->view('template/header');
		$this->load->view('template/leftside');
        $this->load->view('transaksi/pembayaran/index');
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
    } 

    function tambah()
	{   		
		$data = array(
			'd_no_rekening'  => $this->pembayaran->get_no_rekening()
		);

		$this->load->view('template/header');
		$this->load->view('template/leftside');
		$this->load->view('transaksi/pembayaran/tambah',$data);
		$this->load->view('template/footer_js');
		$this->load->view('template/footer');
	}

	function get_data_pembayaran()
    {
        $list = $this->pembayaran->get_datatables_pembayaran();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Transaksi;
            $row[] = $field->Tgl_Transaksi;
            $row[] = $field->Nm_Cust;     
			$row[] = $field->Total_Pembayaran;
			$row[] = $field->Status;
			$row[] = "";
			$data[] = $row;					
        } 
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pembayaran->count_all(),
            "recordsFiltered" => $this->pembayaran->count_filtered(),
            "data" => $data,
		);
		
        echo json_encode($output);
	}

	public function get_nama_bank()
	{
		if($this->input->is_ajax_request())
		{
			$rekening = $this->input->post('rekening');	
			$data = $this->pembayaran->get_baris($rekening)->row();
			$json['Nama_Bank']	= ( ! empty($data->Nama_Bank)) ? $data->Nama_Bank : "";
			echo json_encode($json);
		}
	}

	public function ajax_kode()
	{
		if($this->input->is_ajax_request())
		{
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');
			$kdcust	= $this->input->post('kdcust');
			$barang = $this->pembayaran->cari_kode($keyword, $registered,$kdcust);

			if($barang->num_rows() > 0)
			{
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
				foreach($barang->result() as $b)
				{
					$json['datanya'] .= "
						<li>
							<b>No So</b> : 
							<span id='noso'>".$b->No_So."</span> <br />
							<span id='nmcust'>".$b->Nm_Cust."</span> <br />
							<span id='noref' style='display:none;' >".$b->No_Ref."</span>		
							<span id='tglpiutang' style='display:none;'>".$b->Tgl_So."</span>	
							<span id='tgljtp' style='display:none;'>".$b->Tgl_Jtp."</span>	
							<span id='nompiutang' style='display:none;'>".$b->Nilai_Piutang."</span>
							<span id='sisapiutang' style='display:none;'>".$b->Sisa_Piutang."</span>
							<span id='noref' style='display:none;'>".$b->No_Ref."</span>				
						</li>
					";
				}
				$json['datanya'] .= "</ul>";
			}
			else
			{
				$json['status'] 	= 0;
			}

			echo json_encode($json);
		}
	}

	function idpembayaran(){
		$date= date("Y-m-d");
        $tahun=substr($date, 0, 4);
        $bulan=substr($date, 5, 2);
		$q = $this->db->query("select MAX(RIGHT(No_Transaksi,6)) as kd_max from tb_pembayaran where year(tgl_transaksi) = $tahun ");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
		return "01BR".$tahun.$bulan.$kd;
	}

	
	public function simpan_pembayaran()
	{		
		if($_POST)
			{
				if( ! empty($_POST['kd_cust']))
				{
					if( ! empty($_POST['no_so']))
					{
						$total = 0;
						foreach($_POST['no_so'] as $k)
						{if( ! empty($k)){$total++;}}
							if($total > 0){								
								$no = 0;
								foreach($_POST['no_so'] as $d)
								{
									if( ! empty($d))
									{
									$this->form_validation->set_rules('no_so['.$no.']','No So : '.$_POST['no_so'][$no], 'trim|required|callback_cek_no_so[no_so['.$no.']]');
									}
								$no++;
								}
								$this->form_validation->set_message('cek_no_so', '%s tidak ditemukan');

								if($this->form_validation->run() == TRUE){
									$No_Transaksi 			= $this->idpembayaran();  
									$Tgl_Transaksi			= $this->input->post('tgltransaksi');
									$Kd_Cust				= $this->input->post('kd_cust');
									$No_Bg					= $this->input->post('nobg');
									$Tgl_Bg					= $this->input->post('tglbg');
									$No_Rek					= $this->input->post('norek');
									$Bank_Bg				= $this->input->post('bankbg');
									$Bank_Ku				= $this->input->post('bankku');
									$Tgl_Ku					= $this->input->post('tglku');
									$Nominal_Tunai			= $this->input->post('nomtunai');
									$Nominal_Bg				= $this->input->post('nombg');
									$Nominal_Ku				= $this->input->post('nomku');
									$Total					= $this->input->post('total');
									$Total_Pembayaran		= $this->input->post('totalbayar');
									$Keterangan				= $this->input->post('keterangan');
									$Sisa_Piutang			= $this->input->post('sisa_piutang');
									$Created_By				= $this->session->userdata['nama_lengkap'];
									$Created_Date			= date('Y-m-d');
									
									echo $Sisa_Piutang;
									return false;
									// if ($Total_Pembayaran > $Sisa_Piutang)
									// {
									// 	$this->query_error("Nilai Yang dibayar tidak boleh lebih besar dari sisa piutang");
									// }

									if ($Total != $Total_Pembayaran)
									{
										$this->query_error("Nilai yang harus dibayar Tidak sama dengan jumlah uang yang dibayar </br> data tidak bisa di simpan");
									}else{

										$pembayaran = $this->pembayaran->insert_pembayaran(
															$No_Transaksi, 
															$Tgl_Transaksi, 
															$Kd_Cust, 
															$No_Bg, 
															$Tgl_Bg, 
															$No_Rek, 
															$Bank_Bg,
															$Bank_Ku, 
															$Tgl_Ku, 
															$Nominal_Tunai, 
															$Nominal_Bg, 
															$Nominal_Ku, 
															$Total_Pembayaran, 
															$Keterangan,
															$Created_By, 
															$Created_Date);

										if($pembayaran){
											$inserted	= 0;
											$no_array	= 0;
											foreach($_POST['no_so'] as $k)
											{
												if( ! empty($k))
												{
													$No_Transaksi 		= $this->idpembayaran(); 		
													$No_So 				= $_POST['no_so'][$no_array];
													$No_Ref 			= $_POST['no_ref'][$no_array];
													$Jumlah_Dibayar 	= $_POST['jml_bayar'][$no_array];
													$Tgl_Ref 			= $_POST['tgl_ref'][$no_array];
													$Tgl_Jtp 			= $_POST['tgl_jtp'][$no_array];
													
													$inserted++;
													
													$insert_detail	= $this->pembayaran->insert_pembayaran_detail($No_Transaksi, $No_So, $No_Ref, $Jumlah_Dibayar, $Tgl_Ref, $Tgl_Jtp);
													
												}

												$no_array++;
											}
											
											if($inserted > 0)
											{
												echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
											}
											else
											{
												$this->query_error();
											}
										}
										
									}
								}
								else
								{
									echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ","</font><br />")));
								}
							}else{
								$this->query_error("Harap masukan minimal 1 sales order !");
							}
					}else
					{		
						$this->query_error("Harap masukan minimal 1 sales order !");
					}
				}else
				{
					$this->query_error("Customer harus diisi...");
				}
			}
	}
	
	public function cek_no_so($no_so)
	{
		$this->load->model('transaksi/M_salesorder');
		$cek_no_so = $this->M_salesorder->cek_no_so($no_so);

		if($cek_no_so->num_rows() > 0)
		{
			return TRUE;
		}
		return FALSE;
	}

}