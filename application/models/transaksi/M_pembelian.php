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

    function simpanDataPembelian(){
        $this->db->trans_begin();
        $kd = $this->idPembelian();
 		$Nm_Penjual = $this->input->post('txt_nm_penjual');

        $Tgl_Beli = $this->input->post('txt_tgl_beli');
        $Alamat = $this->input->post('txt_alamat');
        $JnsKel = $this->input->post('opt_jnskel');
        $Kd_Tipe = $this->input->post('kd_tipe');
        $Kd_Warna = $this->input->post('kd_warna');
        $merek = $this->input->post('kd_merek');
        $Kapasitas = $this->input->post('txt_kapasitas');
        $No_Polisi = $this->input->post('txt_no_polisi');
        $No_Chassis = $this->input->post('txt_no_rangka');
        $No_Mesin = $this->input->post('txt_no_mesin');
        $Tgl_Stnk = $this->input->post('txt_tgl_stnk');
        $Ongkir = $this->input->post('txt_ongkir');
        $Thn_Produksi = $this->input->post('txt_thn_produksi');
        $No_Stnk = $this->input->post('txt_no_stnk');
        $No_Bpkb = $this->input->post('txt_no_bpkb');
        $Nm_Stnk = $this->input->post('txt_nm_stnk');

		$data = array(
			'No_Transaksi'=> $kd,
            'Nm_Penjual' => $Nm_Penjual,
            'Tgl_Beli' => $Tgl_Beli,
            'Alamat' => $Alamat,
            'JnsKel' => $JnsKel,
            'Kd_Tipe' => $Kd_Tipe,
            'Kd_Warna' => $Kd_Warna,
            'Kd_Merek' => $merek,
            'Kapasitas' => $Kapasitas,
            'No_Polisi' => $No_Polisi,
            'No_Chassis' => $No_Chassis,
            'No_Mesin' => $No_Mesin,
            'Tgl_Stnk' => $Tgl_Stnk,
            'Ongkir' => $Ongkir,
            'Thn_Produksi' => $Thn_Produksi,
            'No_Stnk' => $No_Stnk,
            'No_Bpkb' => $No_Bpkb,
            'Nm_Stnk' => $Nm_Stnk,
			);

        $this->db->insert('tb_pembelian', $data);

        
        $data_stock = array(
            'No_Mesin' => $No_Mesin,
            'No_Chassis' => $No_Chassis,
            'Kd_Tipe' => $Kd_Tipe,
            'Kd_Warna' => $Kd_Warna,
            'Status' => "Received",
            'Kd_Merek' => $merek,
            'Kapasitas' => $Kapasitas,
            'Thn_Produksi' => $Thn_Produksi,
            'No_Polisi' => $No_Polisi,
            'Tgl_Beli' => $Tgl_Beli,
            'Ongkir' => $Ongkir,
            'No_Stnk' => $No_Stnk,
            'No_Bpkb' => $No_Bpkb,
            'Nm_Stnk' => $Nm_Stnk,
            'Tgl_Stnk' => $Tgl_Stnk   
            );
        $this->db->insert('tb_stock', $data_stock); 
   
        if($this->db->affected_rows() > 0){
            $this->db->trans_commit();
            return true;
        }
        else {
            $this->db->trans_rollback();
            return false;
        }
    }
}