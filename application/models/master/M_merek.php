<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_merek extends CI_Model {

    var $table = 'tb_merek'; //nama tabel dari database
    var $column_order = array(null, 'Kd_Merek','Merek','Status'); //field yang ada di table user
    var $column_search = array('Kd_Merek','Merek','Status'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Merek' => 'asc'); // default order 
 
    private function _get_datatables_query_merek()
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
 
    function get_datatables_merek()
    {
        $this->_get_datatables_query_merek();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_merek();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function idMerek(){
		$q = $this->db->query("select MAX(RIGHT(Kd_Merek,5)) as kd_max from tb_merek");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "MR-".$kd;
    }
    
	function ambilDataMerek(){     
        $query = $this->db->get('tb_merek');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function ambilDataMerekStatus(){  
        $this->db->where('status', 'A');   
        $query = $this->db->get('tb_merek');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function simpanDataMerek(){

        $kd = $this->idMerek();
 		$merek = $this->input->post('txt_merek');

		$data = array(
			'Kd_Merek'=> $kd,
			'Merek' => $merek,
			'status' => "A",
			);

        $this->db->insert('tb_merek', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }
    
    function ambilDataMerekbyID($id){
        $this->db->where('Kd_Merek', $id);
        $query = $this->db->get('tb_merek');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }

     
    function ambilNamaMerek($id){
        $this->db->select('Merek');
        $this->db->from('tb_merek');
        $this->db->where('Kd_Merek', $id);
        $query = $this->db->get('');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }
     function updateDataMerek(){
            $Kd_Merek = $this->input->post('txt_kd_merek');
            $Merek = $this->input->post('txt_merek');
            $Status = $this->input->post('txt_status');

            $data = array(
                'Kd_Merek' => $Kd_Merek,
                'Merek' => $Merek,
                'Status' => $Status
                );

        $this->db->where('kd_merek', $Kd_Merek);
        $this->db->update('tb_merek', $data);
        if($this->db->affected_rows() > 0){
        return true;
        }else {
        return false;
        }
    }
}