<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_laporan extends CI_Model {
    var $table = '( SELECT b.Tipe,c.Warna,a.No_Mesin,a.No_Chassis,a.Status,a.Tgl_Jual
                    FROM db_rilexindo.tb_stock a 
                    inner join db_rilexindo.tb_tipe b on b.Kd_Tipe = a.Kd_Tipe
                    inner join db_rilexindo.tb_warna c on a.Kd_Warna = c.Kd_Warna)A'; //nama tabel dari database
    var $column_order = array(null, 'Tipe','Warna','No_Mesin','No_Chassis','Status','Tgl_Jual'); //field yang ada di table user
    var $column_search = array('Tipe','Warna','No_Mesin','No_Chassis','Status','Tgl_Jual'); //field yang diizin untuk pencarian 
    var $order = array('No_Mesin' => 'asc'); // default order 
 
    private function _get_datatables_query_stokgudang()
    {
        if($this->input->post('status'))
        {
            $this->db->where('status', $this->input->post('status'));
        } 

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
 
    function get_datatables_stokgudang()
    {
        $this->_get_datatables_query_stokgudang();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_stokgudang();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}