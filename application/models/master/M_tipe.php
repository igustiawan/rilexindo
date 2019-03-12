<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_tipe extends CI_Model {

    var $table = '(
                    select k.Kd_Tipe,k.Tipe,p.Merek,k.Status 
                    from tb_tipe as k 
                    join tb_merek as p on p.kd_merek = k.kd_merek
                  )A';    
    var $column_order = array(null, 'Kd_Tipe','Tipe','Merek','Status'); //field yang ada di table user
    var $column_search = array('Kd_Tipe','Tipe','Merek','Status'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Tipe' => 'asc'); // default order 
 
    private function _get_datatables_query_tipe()
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
 
    function get_datatables_tipe()
    {
        $this->_get_datatables_query_tipe();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_tipe();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function ambilDataTipe(){     
        $query = $this->db->get('tb_tipe');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function idTipe(){
		$q = $this->db->query("select MAX(RIGHT(Kd_Tipe,5)) as kd_max from tb_tipe");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "TP-".$kd;
    }

    function simpanDataTipe(){

        $kd = $this->idTipe();
 		$txt_tipe = $this->input->post('txt_tipe');
        $opt_merek = $this->input->post('opt_merek');

		$data = array(
			'Kd_Tipe'=> $kd,
			'Tipe' => $txt_tipe,
            'Kd_Merek' =>  $opt_merek,
            'status' => "A",
			);

        $this->db->insert('tb_tipe', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    function ambilDataTipebyID($id){
        $this->db->where('Kd_Tipe', $id);
        $query = $this->db->get('tb_tipe');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }

     function updateDataTipe(){
        $Kd_Tipe = $this->input->post('txt_kd_tipe');
        $Tipe = $this->input->post('txt_tipe');
        $Merek = $this->input->post('opt_merek');        
        $Status = $this->input->post('txt_status');

        $data = array(
            'Kd_Merek' => $Kd_Tipe,
            'Tipe' => $Tipe,
            'Kd_Merek' => $Merek,
            'Status' => $Status
            );

        $this->db->where('Kd_Tipe', $Kd_Tipe);
        $this->db->update('tb_tipe', $data);
        if($this->db->affected_rows() > 0){
        return true;
        }else {
        return false;
    }
}
}