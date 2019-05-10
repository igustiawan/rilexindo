<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_pembelian extends CI_Model {

    var $table = '(select No_Transaksi,Tgl_Beli,Nm_Penjual,Tipe,Warna,No_Mesin,Thn_Produksi,No_Polisi from tb_pembelian a inner join tb_tipe b on a.Kd_Tipe = b.Kd_Tipe
                  inner join tb_warna c on a.Kd_Warna = c.Kd_Warna) A'; //nama tabel dari database
    var $column_order = array(null, 'No_Transaksi','Tgl_Beli','Nm_Penjual','Tipe','Warna',
                             'No_Mesin','Thn_Produksi','No_Polisi'); //field yang ada di table user
    var $column_search = array('No_Transaksi','Tgl_Beli','Nm_Penjual','Tipe','Warna',
                            'No_Mesin','Thn_Produksi','No_Polisi'); //field yang diizin untuk pencarian 
    var $order = array('No_Transaksi' => 'asc'); // default order 
 
    private function _get_datatables_query_pembelian()
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
 
    function get_datatables_pembelian()
    {
        $this->_get_datatables_query_pembelian();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_pembelian();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function ambilDataPembelian(){     
        $query = $this->db->get('tb_pembelian');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function idPembelian(){
        $date= date("Y-m-d");
        $tahun=substr($date, 0, 4);
        $bulan=substr($date, 5, 2);
		$q = $this->db->query("select MAX(RIGHT(No_Transaksi,6)) as kd_max from tb_pembelian where year(Tgl_Beli) = $tahun");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%06s", $tmp);
            }
        }else{
            $kd = "000001";
        }
        return "TR".$tahun.$bulan.$kd;
    }

    function cek_nosin_validasi($nomesin)
	{
		return $this->db->select('No_Mesin')->where('No_Mesin', $nomesin)->limit(1)->get('tb_stock');
    }
    
    function insert_transaksi_pembelian($txt_nm_penjual, $optJnsKel, $txt_alamat, $kd_tipe, 
                        $kd_merek, $kd_warna, $txt_no_polisi, $txt_no_bpkb, 
                        $txt_nm_stnk, $txt_no_rangka, $txt_no_mesin, $txt_kapasitas, 
                        $txt_thn_produksi, $txt_ongkir,$txt_tgl_beli,$txt_tgl_stnk,
                        $txt_no_stnk)
	{
        $kd = $this->idPembelian();

		$dt = array(
			'No_Transaksi'=> $kd,
            'Nm_Penjual' => $txt_nm_penjual,
            'Tgl_Beli' => $txt_tgl_beli,
            'Alamat' => $txt_alamat,
            'JnsKel' => $optJnsKel,
            'Kd_Tipe' => $kd_tipe,
            'Kd_Warna' => $kd_warna,
            'Kd_Merek' => $kd_merek,
            'Kapasitas' => $txt_kapasitas,
            'No_Polisi' => $txt_no_polisi,
            'No_Chassis' => $txt_no_rangka,
            'No_Mesin' => $txt_no_mesin,
            'Tgl_Stnk' => $txt_tgl_stnk,
            'Ongkir' => $txt_ongkir,
            'Thn_Produksi' => $txt_thn_produksi,
            'No_Stnk' => $txt_no_stnk,
            'No_Bpkb' => $txt_no_bpkb,
            'Nm_Stnk' => $txt_nm_stnk
		);

		return $this->db->insert('tb_pembelian', $dt);
    }
    
    function insert_stok($txt_no_mesin, $txt_no_rangka, $kd_tipe, $kd_warna, 
                        $kd_merek, $txt_kapasitas, $txt_thn_produksi, $txt_no_polisi, 
                        $txt_tgl_beli, $txt_ongkir, $txt_no_stnk,$txt_no_bpkb, 
                        $txt_nm_stnk, $txt_tgl_stnk)
    {
   
        $data_stock = array(
        'No_Mesin' => $txt_no_mesin,
        'No_Chassis' => $txt_no_rangka,
        'Kd_Tipe' => $kd_tipe,
        'Kd_Warna' => $kd_warna,
        'Status' => "Received",
        'Kd_Merek' => $kd_merek,
        'Kapasitas' => $txt_kapasitas,
        'Thn_Produksi' => $txt_thn_produksi,
        'No_Polisi' => $txt_no_polisi,
        'Tgl_Beli' => $txt_tgl_beli,
        'Ongkir' => $txt_ongkir,
        'No_Stnk' => $txt_no_stnk,
        'No_Bpkb' => $txt_no_bpkb,
        'Nm_Stnk' => $txt_nm_stnk,
        'Tgl_Stnk' => $txt_tgl_stnk   
        );

        return $this->db->insert('tb_stock', $data_stock);
    }

}