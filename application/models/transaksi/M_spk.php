<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_spk extends CI_Model {

    var $table = '(select a.No_Spk,a.Nm_Cust,a.Alamat,a.No_Mesin,b.Tipe,c.Warna,a.Jns_Bayar,a.Status 
                   from tb_spk a 
                   left join tb_tipe b on a.kd_tipe = b.kd_tipe
                   left join tb_warna c on a.kd_warna = c.kd_warna) A'; 
    var $column_order = array(null, 'No_Spk','Nm_Cust','Alamat','No_Mesin','Tipe','Warna','Jns_Bayar','Status'); 
    var $column_search = array('No_Spk','Nm_Cust','Alamat','No_Mesin','Tipe','Warna','Jns_Bayar','Status'); //field yang diizin untuk pencarian 
    var $order = array('No_Spk' => 'asc'); 
 
    private function _get_datatables_query_spk()
    {         
        $this->db->from($this->table);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // looping awal
        {
            if($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
            {
                 
                if($i===0) // looping awal
                {
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
 
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) 
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
 
    function get_datatables_spk()
    {
        $this->_get_datatables_query_spk();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_spk();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function AmbilDataSPK(){     
        $query = $this->db->get('tb_spk');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function idSpk(){
		$q = $this->db->query("select MAX(RIGHT(No_Spk,6)) as kd_max from tb_spk");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return $kd;
    }
    
    function insert_transaksi_spk($datepicker, $txt_kd_cust, $txt_cust, $txt_alamat, 
            $kd_salesman, $txt_jns_pembayaran, $txt_kd_merek,
            $txt_kd_tipe, $txt_kd_warna, $txt_harga_kendaraan, $txt_uang_muka, 
            $txt_angsuran, $kd_leasing,$txt_tenor,$txt_bunga,$txt_jns_angsuran,$Status,$Cetak,
            $txt_jns_road,$optJnsKel,$txt_nomesin)
    {
        $kd = $this->idSpk();          
		$dt = array(
			'No_Spk'=> $kd,
            'Tgl_Spk'=> $datepicker,
            'Kd_Cust'=> $txt_kd_cust,
            'Nm_Cust'=> $txt_cust,
            'Alamat'=> $txt_alamat,
            'Kd_Salesman'=> $kd_salesman,
            'Jns_Bayar'=> $txt_jns_pembayaran,
            'Kd_Merek'=> $txt_kd_merek,
            'Kd_Tipe'=> $txt_kd_tipe,
            'Kd_Warna'=> $txt_kd_warna,
            'Jml_Harga'=> $txt_harga_kendaraan,
            'Uang_Muka'=> $txt_uang_muka,
            'Angsuran'=> $txt_angsuran,
            'Kd_Fincoy'=> $kd_leasing,
            'Tenor'=> $txt_tenor,
            'P_Bunga'=> $txt_bunga,
            'Tipe_Angs'=> $txt_jns_angsuran,
            'Status'=> "Waiting Process",
            'Cetak'=> "0",
            'Stat_OTR'=> $txt_jns_road,
            'Jns_Kel'=> $optJnsKel,
            'No_Mesin'=> $txt_nomesin
		);

		return $this->db->insert('tb_spk', $dt);

    }
    // function simpanDataSpk(){

    //     $kd = $this->idSpk();
    //     $Tgl_Spk = $this->input->post('txt_tgl_spk');
    //     $Kd_Cust = $this->input->post('txt_kd_cust');
    //     $Nm_Cust = $this->input->post('txt_cust');
    //     $Alamat = $this->input->post('txt_alamat');
    //     $Kd_Salesman = $this->input->post('kd_salesman');
    //     $Jns_Bayar = $this->input->post('txt_jns_pembayaran');
    //     $Kd_Merek = $this->input->post('txt_kd_merek');
    //     $Kd_Tipe = $this->input->post('txt_kd_tipe');
    //     $Kd_Warna = $this->input->post('txt_kd_warna');
    //     $Jml_Harga = $this->input->post('txt_harga_kendaraan');  
    //     $Uang_Muka = $this->input->post('txt_uang_muka');  
    //     $Angsuran = $this->input->post('txt_angsuran'); 
    //     $Kd_Fincoy = $this->input->post('kd_leasing'); 
    //     $Tenor = $this->input->post('txt_tenor'); 
    //     $P_Bunga = $this->input->post('txt_bunga'); 
    //     $Tipe_Angs = $this->input->post('txt_jns_angsuran'); 
    //     $Status = "Waiting Process"; 
    //     $Cetak = "0";
    //     $Stat_OTR = $this->input->post('txt_jns_road'); 
    //     $Jns_Kel = $this->input->post('opt_jnskel'); 
    //     $No_Mesin = $this->input->post('txt_nomesin'); 

	// 	$data = array(
    //         'No_Spk'=> $kd,
    //         'Tgl_Spk'=> $Tgl_Spk,
    //         'Kd_Cust'=> $Kd_Cust,
    //         'Nm_Cust'=> $Nm_Cust,
    //         'Alamat'=> $Alamat,
    //         'Kd_Salesman'=> $Kd_Salesman,
    //         'Jns_Bayar'=> $Jns_Bayar,
    //         'Kd_Merek'=> $Kd_Merek,
    //         'Kd_Tipe'=> $Kd_Tipe,
    //         'Kd_Warna'=> $Kd_Warna,
    //         'Jml_Harga'=> $Jml_Harga,
    //         'Uang_Muka'=> $Uang_Muka,
    //         'Angsuran'=> $Angsuran,
    //         'Kd_Fincoy'=> $Kd_Fincoy,
    //         'Tenor'=> $Tenor,
    //         'P_Bunga'=> $P_Bunga,
    //         'Tipe_Angs'=> $Tipe_Angs,
    //         'Status'=> $Status,
    //         'Cetak'=> $Cetak,
    //         'Stat_OTR'=> $Stat_OTR,
    //         'Jns_Kel'=> $Jns_Kel,
    //         'No_Mesin'=> $No_Mesin
	// 		);

    //     $this->db->insert('tb_spk', $data);
    //     if($this->db->affected_rows() > 0){
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
    // }

    function get_list_spk(){ 
        $query = $this->db->query("select * from tb_spk where Status = 'Process' and No_Spk not in (select no_spk from tb_so where status !='Batal')");
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function prosesDataSpk(){
        $No_Spk=$this->input->post('txt_no_spk');
        $No_Mesin=$this->input->post('txt_no_mesin');

        $this->db->query("update tb_spk set status='Process' where No_Spk = '$No_Spk'");
        $this->db->query("update tb_stock set No_Spk='$No_Spk',Tgl_Book_Spk=now() where No_Mesin = '$No_Mesin'");

        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    // function role_exists($key)
    // {
    //     $this->db->where('No_Mesin',$key);
    //     $this->db->where('Status != ','Batal',FALSE);
    //     $query = $this->db->get('tb_spk');
    //     if ($query->num_rows() > 0){
    //         return true;
    //     }
    //     else{
    //         return false;
    //     }
    // }

    function batalspk(){
        $No_Spk=$this->input->post('txt_no_spk');    
        $this->db->query("update tb_spk set status='Batal' where No_Spk = '$No_Spk'");     
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

}