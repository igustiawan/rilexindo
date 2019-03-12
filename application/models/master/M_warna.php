<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_warna extends CI_Model {

    var $table = 'tb_warna'; //nama tabel dari database
    var $column_order = array(null, 'Kd_Warna','Warna','Status'); //field yang ada di table user
    var $column_search = array('Kd_Warna','Warna','Status'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Warna' => 'asc'); // default order 
 
    private function _get_datatables_query_warna()
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
 
    function get_datatables_warna()
    {
        $this->_get_datatables_query_warna();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_warna();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function ambilDataWarna(){     
        $query = $this->db->get('tb_warna');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function idWarna(){
		$q = $this->db->query("select MAX(RIGHT(Kd_Warna,5)) as kd_max from tb_warna");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "WR-".$kd;
    }

    function simpanDataWarna(){

        $kd = $this->idWarna();
 		$warna = $this->input->post('txt_warna');

		$data = array(
			'Kd_Warna'=> $kd,
			'Warna' => $warna,
			'status' => "A",
			);

        $this->db->insert('tb_warna', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    
    function ambilDataWarnaStatus(){  
        $this->db->where('status', 'A');   
        $query = $this->db->get('tb_warna');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function ambilDataWarnabyID($id){
        $this->db->where('Kd_Warna', $id);
        $query = $this->db->get('tb_warna');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }

     function updateDataWarna(){
        $Kd_Warna = $this->input->post('txt_kd_warna');
        $Warna = $this->input->post('txt_warna');
        $Status = $this->input->post('txt_status');

        $data = array(
            'Kd_Warna' => $Kd_Warna,
            'Warna' => $Warna,
            'Status' => $Status
            );

    $this->db->where('Kd_Warna', $Kd_Warna);
    $this->db->update('tb_warna', $data);
    if($this->db->affected_rows() > 0){
    return true;
    }else {
    return false;
    }
}

}