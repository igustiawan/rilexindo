<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salesorder extends CI_Controller {

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
				'<a target="__blank" href="'.base_url('transaksi/salesorder/cetak/'.$field->No_So).'" class="btn btn-default btn-sm"><i class="fa fa-print"></i></a>'
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

	function simpan(){
		$hasil = $this->salesorder->simpanDataSalesOrder();
		if($hasil){
			$this->session->set_flashdata('psn_sukses','Data telah disimpan');
		}
		else {
			$this->session->set_flashdata('psn_error','Gagal menyimpan data ');
		}
		redirect(base_url('transaksi/salesorder'));
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

	public function cetak($id)
	{
	
		
		$order_data = $this->salesorder->getOrdersData($id);

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

		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();

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

		$pdf->Output();


	}

}