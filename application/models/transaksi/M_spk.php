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
            $kd_salesman, $txt_jns_pembayaran, $txt_kd_merek,$txt_kd_tipe, 
            $txt_kd_warna, $txt_harga_kendaraan, $txt_uang_muka,$txt_angsuran, 
            $kd_leasing,$txt_tenor,$txt_bunga,$txt_jns_angsuran,
            $Status,$Cetak,$txt_jns_road,$optJnsKel,$txt_nomesin)
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

    public function getSpkData($No_Spk = null)
	{
		if($No_Spk) {
			$sql = "SELECT *,b.Merek,C.Tipe,d.Warna 
            FROM tb_spk a 
            inner join tb_merek b on a.Kd_Merek = b.Kd_Merek
            inner join tb_tipe c on a.Kd_Tipe = c.Kd_Tipe 
            inner join tb_warna d on a.Kd_Warna = d.Kd_Warna
            WHERE No_Spk = ?";
			$query = $this->db->query($sql, array($No_Spk));
			return $query->row_array();
		}

		$sql = "SELECT *,b.Merek,C.Tipe,d.Warna 
        FROM tb_spk a 
        inner join tb_merek b on a.Kd_Merek = b.Kd_Merek
        inner join tb_tipe c on a.Kd_Tipe = c.Kd_Tipe 
        inner join tb_warna d on a.Kd_Warna = d.Kd_Warna
        ORDER BY No_Spk DESC";
		$query = $this->db->query($sql);
		return $query->result_array();
    }
    
    function update_transaksi_spk($No_Spk,$datepicker, $txt_alamat,$kd_salesman, 
            $txt_jns_pembayaran, $txt_kd_merek,$txt_kd_tipe,$txt_kd_warna, 
            $txt_harga_kendaraan, $txt_uang_muka,$txt_angsuran,$kd_leasing,
            $txt_tenor,$txt_bunga,$txt_jns_angsuran,$txt_jns_road,$optJnsKel)
	{
		$dt['Tgl_Spk']      = $datepicker;
		$dt['Alamat']		= $txt_alamat;
		$dt['Kd_Salesman']	= $kd_salesman;
		$dt['Jns_Bayar']	= $txt_jns_pembayaran;
        $dt['Kd_Merek']     = $txt_kd_merek;
		$dt['Kd_Tipe']		= $txt_kd_tipe;
		$dt['Kd_Warna']	    = $txt_kd_warna;
        $dt['Jml_Harga']	= $txt_harga_kendaraan;
        $dt['Uang_Muka']    = $txt_uang_muka;
		$dt['Angsuran']		= $txt_angsuran;
		$dt['Kd_Fincoy']	= $kd_leasing;
        $dt['Tenor']	    = $txt_tenor;
        $dt['P_Bunga']      = $txt_bunga;
		$dt['Tipe_Angs']	= $txt_jns_angsuran;
		$dt['Stat_OTR']	    = $txt_jns_road;
		$dt['Jns_Kel']	    = $optJnsKel;

		return $this->db
			->where('No_Spk', $No_Spk)
			->update('tb_spk', $dt);
    }
    

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

    function proses_spk($No_Spk)
	{      
        $dt['status'] = 'Process';
        
		return $this->db
				->where('No_Spk', $No_Spk)
                ->update('tb_spk', $dt);                    
    }

    function update_stok_spk($no_mesin,$No_Spk)
	{
        $dt_stok['No_Spk'] = $No_Spk;
        $dt_stok['Tgl_Book_Spk'] =date('Y-m-d H:i:s');

        return $this->db
                ->where('No_Mesin', $no_mesin)
                ->update('tb_stock', $dt_stok);   
    }
    
    function batal_spk($No_Spk)
	{      
        $dt['status'] = 'Batal';
        
		return $this->db
				->where('No_Spk', $No_Spk)
                ->update('tb_spk', $dt);                    
    }

}