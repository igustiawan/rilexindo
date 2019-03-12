<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicekendaraan extends CI_Controller {

    public function __construct()
	{
		parent::__construct();
        $this->load->model('transaksi/M_servicekendaraan','servicekendaraan');
	}

    function index(){
        $data = array(
            'h_servicekendaraan' => $this->servicekendaraan->ambilDataHdrServicekendaraan()
		);

        $this->document->generate_page('transaksi/servicekendaraan/index', $data);
    } 

    function tambah(){
        $data = array();
        $this->document->generate_page('transaksi/servicekendaraan/tambah', $data);
    }

    function detail($id){
        $data = array(
            'list' => $this->servicekendaraan->getInfo($id)
        );
        $this->document->generate_page('transaksi/servicekendaraan/detail', $data);
    }

    function simpan_data(){
        $no_mesin = $this->input->post('txt_nomesin');
        $tgl_service = $this->input->post('txt_tgl_service');
        $keterangan = $this->input->post('txt_keterangan');
        $kd_service = $this->input->post('kd_service');
        $deskripsi = $this->input->post('deskripsi');
        $cost = $this->input->post('cost');

        $index = 0;
        $total_harga_service = 0;
        $data_detail = array();

        // $id = $this->M_general->generate_id();
        $id = $this->M_general->generate_custom_id('tb_service_kendaraan', 'No_Transaksi', 'TRX', 5);

        foreach ($kd_service as $key => $value) {
            array_push($data_detail, array(
                'Fk_Transaksi'  =>  $id,
                'Seq_No'        =>  $index,
                'Kd_Service'    =>  $value,
                'Deskripsi'     =>  $deskripsi[$key],  // Ambil dan set data nama sesuai index array dari $index
                'Biaya_Service' =>  number_only($cost[$key]) // Ambil dan set data telepon sesuai index array dari $index
            ));

            $total_harga_service += number_only($cost[$key]);
            $index++;
        }

        $data_header = array(
            'No_Transaksi'  => $id,
            'Tgl_Service'   => $tgl_service,
            'No_Mesin'      => $no_mesin,
            'Keterangan'    => $keterangan,
            'Total_Harga'   => $total_harga_service,
            'Status'        => 'A'
        );

        $hasil = $this->servicekendaraan->simpanHeaderDetailService($data_header, $data_detail);
        if($hasil){
            $this->session->set_flashdata('psn_sukses','Data telah disimpan');
        }
        else {
            $this->session->set_flashdata('psn_error','Gagal menyimpan data ');
        }
        redirect('transaksi/servicekendaraan');
    }

    function update_data($id){


    }

    function get_data_servicekendaraan(){
        $list = $this->servicekendaraan->get_datatables_servicekendaraan();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $field) {
            $row = array();
            $row[] = $field->No_Transaksi;
            // $row[] = datetime_only($field->Tgl_Service);
            $row[] = ($field->Tgl_Service);
            $row[] = $field->No_Mesin;
            $row[] = $field->Keterangan;
            $row[] = number_this($field->Total_Harga);
            // if ($field->Status=="A"){
            //     $row[]='<span class="label label-default">Baru</span>';     
            // }else{
            //     $row[]='<span class="label label-warning">Proses</span>';  
            // }
            $row[] = '<a href="'.base_url().'transaksi/servicekendaraan/detail/'.$field->No_Transaksi.'" rel="tooltip" class="btn btn-info btn-xs" title="Ubah"><i class="fa fa-eye " ></i>';
            $data[] = $row;
        } 

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->servicekendaraan->count_all(),
            "recordsFiltered" => $this->servicekendaraan->count_filtered(),
            "data" => $data,
        );

        echo json_encode($output); //output dalam format JSON
    }

    function getListKendaraan(){
        $q = $_GET['search'];
        $list = array();

        $get_data = $this->servicekendaraan->getListKendaraan($q);
        if($get_data!=false){
            $key=0;

            foreach ($get_data as $key => $row_data) {
                $list[$key]['id'] = $row_data->No_Mesin;
                $list[$key]['text'] = $row_data->No_Mesin; 
            }
        }
        echo json_encode($list); //output dalam format JSON
    }

    function getJasaService(){
        $index = $this->input->post('row');
        $get_data = $this->servicekendaraan->getListJasaService(false);

        $option = '<select class="form-control detail_kd_service" index="'.$index.'" name="kd_service['.$index.']">';
        $option .= '<option value="-1"> -- Pilih -- </option>';
        if($get_data!=false){
            foreach ($get_data as $key => $row_data) {
                $option .= '<option value="'.$row_data->Kd_Service.'">'.$row_data->Kd_Service.'</option>';
            }
        }
        $option .='</select>';

        $form = '<tr id="row_'.$index.'">';
        $form .= '<td>'.$option.'</td>';
        $form .= '<td><input type="text" readonly class="form-control" name="deskripsi['.$index.']"></td>';        
        $form .= '<td><input type="text" readonly class="form-control text-right" name="cost['.$index.']"></td>';     
        $form .= '<td><button onclick="deleteRow('.$index.')" type="button" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash"></span></button></td>';
        $form .= '</tr>';

        $output['form'] = $form;

        echo json_encode($output);
    }

    function getHargaService(){
        $serviceId = $this->input->post('serviceID');
        $get_data = $this->servicekendaraan->getListJasaService($serviceId);

        $data = array();
        if($get_data!=false){
            $data['deskripsi'] = $get_data[0]->Deskripsi;
            $data['harga'] = $get_data[0]->Harga;
        }else{
            $data['deskripsi'] = '';
            $data['harga'] = '';
        }

        echo json_encode($data); //output dalam format JSON
    }
}