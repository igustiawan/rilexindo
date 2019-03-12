<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_stock_kendaraan extends CI_Model{
    var $table = '(
    SELECT a.No_Mesin,a.No_Chassis,b.kd_tipe,b.Tipe,a.kd_merek,c.Merek,a.Kd_Warna,d.Warna,a.Hrg_Jual  
    FROM db_rilexindo.tb_stock a 
    inner join db_rilexindo.tb_tipe b on a.Kd_Tipe = b.Kd_Tipe
    inner join db_rilexindo.tb_merek c on a.Kd_Merek = c.Kd_Merek
    inner join db_rilexindo.tb_warna d on a.Kd_Warna = d.Kd_Warna
    where a.status = "Received" and No_Spk is NULL
    and a.No_Mesin not in (select No_Mesin from tb_spk where status != "Batal")
    ) A'; 

    var $column_order = array(null, 'No_Mesin','No_Chassis','kd_tipe','Tipe','kd_merek','Merek','Kd_Warna','Warna','Hrg_Jual'); //field yang ada di table user
    var $column_search = array('No_Mesin','No_Chassis','kd_tipe','Tipe','kd_merek','Merek','Kd_Warna','Warna','Hrg_Jual'); //field yang diizin untuk pencarian 
    var $order = array('No_Mesin' => 'asc'); // default order 
 
    private function _get_datatables_query_stock()
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
 
    function get_datatables_stock()
    {
        $this->_get_datatables_query_stock();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_stock();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

}