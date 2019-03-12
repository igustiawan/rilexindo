<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_salesman extends CI_Model {

    var $table = 'tb_salesman'; //nama tabel dari database
    var $column_order = array(null, 'Kd_Salesman','Nm_Salesman','Alamat1','Alamat2','Telepon','Status'); //field yang ada di table user
    var $column_search = array('Kd_Salesman','Nm_Salesman','Alamat1','Alamat2','Telepon','Status'); //field yang diizin untuk pencarian 
    var $order = array('Kd_Salesman' => 'asc'); // default order 
 
    private function _get_datatables_query_salesman()
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
 
    function get_datatables_salesman()
    {
        $this->_get_datatables_query_salesman();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
 
    function count_filtered()
    {
        $this->_get_datatables_query_salesman();
        $query = $this->db->get();
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function idSalesman(){
		$q = $this->db->query("select MAX(RIGHT(kd_Salesman,5)) as kd_max from tb_salesman");
        $kd = "";
        if($q->num_rows()>0){
            foreach($q->result() as $k){
                $tmp = ((int)$k->kd_max)+1;
                $kd = sprintf("%05s", $tmp);
            }
        }else{
            $kd = "00001";
        }
        return "SM-".$kd;
    }

    function ambilDataSalesman(){     
        $query = $this->db->get('tb_salesman');
        if($query->num_rows()>0)
        {
        return $query->result();
        }
        else
        {
        return false;
        }
    }

    function ambilDataSalesmanbyID($id){
        $this->db->where('Kd_Salesman', $id);
        $query = $this->db->get('tb_salesman');
        if($query->num_rows()>0)
        {
          return $query->row();
        }
        else
        {
          return false;
        }
     }

    function simpanDataSalesman(){

        $kd = $this->idSalesman();
        $Nm_Salesman = $this->input->post('txt_nm_salesman');
        $Alamat1 = $this->input->post('txt_alamat1');
        $Alamat2 = $this->input->post('txt_alamat2');
        $Telepon = $this->input->post('txt_telepon');

		$data = array(
			'Kd_Salesman'=> $kd,
            'Nm_Salesman' => $Nm_Salesman,
            'Alamat1' => $Alamat1,
            'Alamat2' => $Alamat2, 
            'Telepon' => $Telepon,            
			'status' => "A",
			);

        $this->db->insert('tb_salesman', $data);
        if($this->db->affected_rows() > 0){
            return true;
        }
        else {
            return false;
        }
    }

    function updateDataSalesman(){
        $Kd_Salesman = $this->input->post('txt_kd_salesman');
        $Nm_Salesman = $this->input->post('txt_nm_salesman');
        $Alamat1 = $this->input->post('txt_alamat1');
        $Alamat2 = $this->input->post('txt_alamat2');
        $Telepon = $this->input->post('txt_telepon');
        $Status = $this->input->post('txt_status');

        $data = array(
            'Kd_Salesman' => $Kd_Salesman,
            'Nm_Salesman' => $Nm_Salesman,
            'Alamat1' => $Alamat1,
            'Alamat2' => $Alamat2, 
            'Telepon' => $Telepon,
            'Status' => $Status
            );

    $this->db->where('kd_salesman', $Kd_Salesman);
    $this->db->update('tb_salesman', $data);
    if($this->db->affected_rows() > 0){
    return true;
    }else {
    return false;
    }
}

}