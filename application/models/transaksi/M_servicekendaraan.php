<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_servicekendaraan extends CI_Model {

    var $table = 'tb_service_kendaraan'; 
    var $column_order = array(null, 'No_Transaksi','Tgl_Service','No_Mesin','Keterangan','Total_Harga','Status'); 
    var $column_search = array('No_Transaksi','Tgl_Service','No_Mesin','Keterangan','Total_Harga','Status'); //field yang diizin untuk pencarian 
    var $order = array('No_Transaksi' => 'asc'); 
 
    private function _get_datatables_query_servicekendaraan()
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
 
    function get_datatables_servicekendaraan()
    {
        $this->_get_datatables_query_servicekendaraan();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_servicekendaraan();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function ambilDataHdrServicekendaraan(){     
        $query = $this->db->get('tb_service_kendaraan');
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return false;
        }
    }

    function getListKendaraan($search){
        // $this->db->select('a.No_Mesin, a.No_Chassis, b.Tipe, c.Warna, b.Kd_Merek, a.No_Polisi');
        // $this->db->join('tb_tipe b', 'a.Kd_Tipe = b.Kd_Tipe');
        // $this->db->join('tb_warna c', 'a.Kd_Warna = c.Kd_Warna');
        $this->db->select('a.No_Mesin');
        $this->db->where('a.Status','Received');
        if($search){
            $this->db->where("a.No_Mesin like '%$search%'");
        }
        $query = $this->db->get('tb_stock a');
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return false;
        }
    }

    function getListJasaService($serviceID = false){
        $this->db->select('Kd_Service, Deskripsi, Harga');
        if($serviceID != false){
            $this->db->where('Kd_Service', $serviceID);
        }
        $this->db->where('Status','A');
        $query = $this->db->get('tb_jasaservice');
        if($query->num_rows()>0){
            return $query->result();
        }else{
            return false;
        }
    }

    function simpanHeaderDetailService($data_header, $data_detail){
        $this->db->trans_start(); // the start/complete functions will be committed or rolled back all based on success or failure of any given query.

        // insert header tb_service_kendaraan
        $this->M_general->insert_data('tb_service_kendaraan',$data_header);

        // insert detail tb_service_kendaraan_detail
        $this->M_general->multiple_insert_data('tb_service_kendaraan_detail',$data_detail);

        // setelah diinsert tambahan biaya service di table stock, functionnya ada di trigger mysql = 'calculate_ttl_service_kendaraan'

        $this->db->trans_complete();
        return true;
    }

    function getInfo($id){
        $this->db->select('*');
        $this->db->where('No_Transaksi', $id);
        $this->db->join('tb_service_kendaraan_detail b','a.No_Transaksi = b.Fk_Transaksi');
        $query = $this->db->get('tb_service_kendaraan a');
          if($query->num_rows()>0){
            return $query->result();
        }else{
            return false;
        }
    }
}